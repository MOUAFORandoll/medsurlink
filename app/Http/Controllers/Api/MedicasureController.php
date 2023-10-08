<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Models\Patient;
use App\Models\ReponseSecrete;
use App\Models\Souscripteur;
use App\User;
use App\Models\TimeActivite;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Psy\Util\Json;

class MedicasureController extends Controller
{
    use PersonnalErrors;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Enregistrement d'un souscripteur à partir des informations de la commande sur CIM.MEDICASURE.COM
     * et authentification
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSouscripteur(Request $request, $email)
    {
        $user = User::whereEmail($email)->first();
        $souscripteur = null;
        if ($user) {
            $souscripteur = Souscripteur::where("user_id", $user->id)->first();
        }
        if (!$souscripteur) {
            // Récupération des informations de la commande end point cim.medicasure.com
            try {
                $client = new Client();
                $env = strtolower(config('app.env'));
                if ($env == 'local')
                    $url = 'http://localhost:8000/api/v1.0.1/souscripteur/email/' . $email;
                else if ($env == 'staging')
                    $url = 'https://www.staging.medicasure.com/api/v1.0.1/souscripteur/email/' . $email;
                else
                    $url = 'https://redirections-medicasure.medsurlink.com/api/v1.0.1/souscripteur/email/' . $email;

                $res = $client->request('GET', $url, [
                    'auth' => [
                        'EktzFuEm2Hrg92ZfmRzkeNcA2NYEeNVpjVcA4KdPVcyABvFmpUgFAE@medicasure.com',
                        '4qaxvbvfUyseXybr973KTkrkESbRc9S6H8eqy5uCDGfpMkDTK74kTY'
                    ],
                ]);

                $affiliation = json_decode($res->getBody()->getContents());
                $request = $affiliation->reponse;
                $userInformation = [];
                $userInformation['nom'] = $request->nom;
                $userInformation['prenom'] = $request->prenom;
                $userInformation['email'] = $request->email;
                $userInformation['nationalite'] = "";
                $userInformation['quartier'] = "";
                $userInformation['code_postal'] = "";
                $userInformation['ville'] = "";
                $userInformation['pays'] = "";
                $userInformation['telephone'] = $request->phone;
                $userInformation['adresse'] = $request->adresse;
                $passwordSouscripteur = $request->password;
                $user = genererCompteUtilisateurMedsurlink($userInformation, $passwordSouscripteur, '1');

                // Assignation du role souscripteur
                $user->assignRole('Souscripteur');

                // Enregistrement des informations personnels du souscripteur
                $souscripteur = Souscripteur::create(['user_id' => $user->id, 'sexe' => '']);

                $tokenInfo = $passwordSouscripteur . 'medsur' . $request->email;

                // Envoi du mail avec mot de passe souscripteur
                try {
                    sendUserInformationViaMail($user, $passwordSouscripteur);
                } catch (\Swift_TransportException $transportException) {
                    $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
                    return response()->json(['reponse' => $tokenInfo, 'souscripteur' => $user, "message" => $message]);
                }
                return response()->json(['reponse' => $tokenInfo], 200);
            } catch (ClientException $exception) {
                return response()->json(['reponse' => $exception], 404);
            }
        } else {
            $passwordSouscripteur = $request->password;
            $tokenInfo = $passwordSouscripteur . 'medsur' . $request->email;
            return response()->json(['reponse' => $tokenInfo], 200);
        }
    }

    public function storeSouscripteurRedirect(Request $request, $email)
    {
        $token = $this->storeSouscripteur($request, $email);
        $updatePath = 'token=';
        $reponse = $token->getOriginalContent()['reponse'];

        $env = strtolower(config('app.env'));
        if ($token->getStatusCode() == 200) {
            $updatePath = 'status=success&' . $updatePath . $reponse;
        } else {
            $updatePath = 'status=' . $reponse . '&' . $updatePath;
        }
        if ($env === 'local')
            return  redirect('http://localhost:8080/contrat-prepaye/add?' . $updatePath);
        else if ($env === 'staging')
            return  redirect('https://www.staging.medsurlink.com/contrat-prepaye/add?' . $updatePath);
        else
            return  redirect('https://www.medsurlink.com/contrat-prepaye/add?' . $updatePath);
    }

    /**
     * Enregistrement d'un patient grace à une commande prépayé
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\PersonnnalException
     */
    public function storePatient(Request $request)
    {
        $souscripteur_id = $request->souscripteur_id;
        $commande_id = $request->commande_id;

        // Recupération des informations relative à la commande
        $commande =  \App\Models\Medicasure::whereId($commande_id)->first();

        $validator = Validator::make($request->all(), [
            'question_id' => 'required|integer|exists:questions,id',
            'reponse' => 'required|string',
            'commande_id' => 'required|integer|exists:affiliation_souscripteurs,id'
        ]);

        if ($validator->fails()) {
            return  response()->json($validator->errors()->all(), 400);
        }

        // Récupération des informations relatifs au souscripteur
        $souscripteur = Souscripteur::with('user')->where('user_id', '=', $souscripteur_id)->first();
        if ($commande) {
            if ($commande->nombre_restant > 0) {
                // Récupération des informations nécessaire pour la création du compte utilisateur medsurlink
                $userInformation = configurerUserMedsurlink($request);

                // Création du compte utilisateur du patient medsurlink
                $passwordPatient = substr(bin2hex(random_bytes(10)), 0, 7);
                $user = genererCompteUtilisateurMedsurlink($userInformation, $passwordPatient, '1');

                // Enregistrement des informations personnels du patient
                $patient = Patient::create([
                    'user_id' => $user->id,
                    'sexe' => $request->sexe,
                    'date_de_naissance' => $request->date_de_naissance
                ]);

                // Enregistrement des informations de question secrete et reponse secrete
                ReponseSecrete::create(['reponse' => $request->reponse, 'question_id' => $request->question_id, 'user_id' => $user->id]);

                // Assignation du role patient
                $user->assignRole('Patient');

                //Génération du dossier médical
                $dossier = genererDossierMedical($patient->user_id);

                //Ajout du patient à la liste de suivi
                $suivi = ajouterPatientAuSuivi($dossier->id, 1);

                // Ajout du souscripteur à la liste des souscripteurs du patient
                $patient->ajouterSouscripteur($souscripteur_id);

                // Réduction du nombre de commande restante
                $commande = reduireCommandeRestante($request->commande_id);

                // Génération du contrat
                $patientMedicasure = transformerEnAffilieMedicasure($patient);
                $souscripteurMedicasure = transformerEnSouscripteurMedicasure($souscripteur);
                $detailContrat = transformerCommande($commande, $request, $souscripteur->user->pays);
                genererContrat($detailContrat + $souscripteurMedicasure + $patientMedicasure);

                // Envoi sms et mail de creation de compte au patient
                sendUserInformationViaSms($user, $passwordPatient);
                sendUserInformationViaMail($user, $passwordPatient);

                // Envoi sms et mail de mise à jour de compte au souscripteur
                notifierMiseAJourCompte($souscripteur, $patient);


                return response()->json(['patient' => $patient]);
            } else {
                $this->revealError('commande_restant', 'Commande restant égale 0, vous ne pouvez plus ajouter de patients');
            }
        } else {
            $this->revealError('commande_not_definie', 'La commande dont l\'identifiant a été transmis n\'existe pas');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function affiliationRestante($id)
    {
        $commande = resteDeCommande($id);

        return response()->json(['commande' => $commande]);
    }
}
