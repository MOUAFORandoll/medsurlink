<?php
/**
 * verifit si l'utilisateur est de la spécialité précisé
 *
 * @param null $user
 * @param string $specialite
 * @return bool
 */

use App\Mail\Password\PasswordGenerated;
use App\Mail\PatientAffiliated;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

if(!function_exists('estIlSpecialisteDe')) {
    function estIlSpecialisteDe($specialite,$user = null)
    {

        if (is_null($user)){
            $user = \Illuminate\Support\Facades\Auth::user();
        }
        //Recupération du rôle de l'utilisateur
        $role = $user->getRoleNames()->first();

        //Evaluation pour le cas praticien
        if ($role == "Praticien"){
//            return $user->praticien->specialite->name == $specialite;
        }

        //Evaluation pour le cas Medecin contrôle
        if ($role == "Medecin controle"){
//            return $user->medecinControle->specialite->name == $specialite;
        }

        return false;

    }
}

if(!function_exists('genererCompteMedsurlink')) {
    function genererCompteUtilisateurMedsurlink($userInformation,$password,$isMedicasure)
    {
        $user = User::create([
            'nom'=>$userInformation['nom'],
            'prenom'=>$userInformation['prenom'],
            'email'=>$userInformation['email'],
            'nationalite'=>$userInformation['nationalite'],
            'quartier'=>$userInformation['quartier'],
            'code_postal'=>$userInformation['code_postal'],
            'ville'=>$userInformation['ville'],
            'pays'=>$userInformation['pays'],
            'telephone'=>$userInformation['telephone'],
            'adresse'=>$userInformation['adresse'],
            'isMedicasure'=>$isMedicasure ,
            'isNotice'=>'0',
            'password'=>Hash::make($password),
            'decede'=>'non'
        ]);

        return $user;
    }
}

if(!function_exists('sendUserInformationViaMail')) {
    function sendUserInformationViaMail($user,$password)
    {
        if (!is_null($user->email)){
            $mail = new PasswordGenerated($user,$password);
            Mail::to($user->email)->send($mail);
        }

    }
}

if(!function_exists('sendUserInformationViaSms')) {
    function sendUserInformationViaSms($user,$password)
    {
        $nom = substr(strtoupper( $user->nom),0,9);
        sendSMS($user->telephone,trans('sms.accountCreated',['nom'=>$nom,'password'=>$password],'fr'));
    }
}

if(!function_exists('notifierMiseAJourCompte')) {
    function notifierMiseAJourCompte($souscripteur, $patient)
    {
        if (!is_null($souscripteur)) {
            try {
                $user = $souscripteur->user;
                sendSmsToUser($user);

                $mail = new PatientAffiliated($souscripteur, $patient);
                Mail::to($souscripteur->user->email)->send($mail);
            } catch (\Swift_TransportException $transportException) {
                $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
                return response()->json(['utilisateur' => $user, "message" => $message]);
            }
        }
    }
}

if(!function_exists('transformerEnAffilieMedicasure')) {
    function transformerEnAffilieMedicasure($patient)
    {
        $patientMedicasure['nomAffilie']  = $patient->user->nom;
        $patientMedicasure['prenomAffilie'] = $patient->user->prenom;
        $patientMedicasure['telephoneAffilie1'] = $patient->user->telephone;
        $patientMedicasure['sexeAffilie'] = $patient->sexe;
        $patientMedicasure['villeResidenceAffilie'] = $patient->user->ville;
        $patientMedicasure['dateNaissanceAffilie'] = $patient->date_de_naissance;
        $patientMedicasure['adresse_affilie'] = $patient->user->adresse;

        return $patientMedicasure;
    }
}

if(!function_exists('transformerEnSouscripteurMedicasure')) {
    function transformerEnSouscripteurMedicasure($souscripteur)
    {
        $souscripteurMedicasure['nomSouscripteur']  = $souscripteur->user->nom;
        $souscripteurMedicasure['prenomSouscripteur'] = $souscripteur->user->prenom;
        $souscripteurMedicasure['telephoneSouscripeur1'] = $souscripteur->user->telephone;
        $souscripteurMedicasure['sexeSouscripteur'] = $souscripteur->sexe ? $souscripteur->sexe :'M';
        $souscripteurMedicasure['emailSouscripteur1'] = $souscripteur->user->email;
        $souscripteurMedicasure['villeResidenceSouscripteur'] = $souscripteur->user->ville;
        $souscripteurMedicasure['paysResidenceSouscripteur'] = $souscripteur->user->pays;
        $souscripteurMedicasure['dateNaissanceSouscripteur'] = $souscripteur->date_de_naissance;

        return $souscripteurMedicasure;
    }
}
if(!function_exists('configurerUserMedsurlink')) {
    function configurerUserMedsurlink($request)
    {
        $userInformation['nom']=$request->nom;
        $userInformation['prenom']=$request->prenom;
        $userInformation['email']=$request->email;
        $userInformation['nationalite']=$request->nationalite;
        $userInformation['quartier']=$request->quartier;
        $userInformation['code_postal']=$request->code_postal;
        $userInformation['ville']=$request->ville;
        $userInformation['pays']=$request->pays;
        $userInformation['telephone']=$request->telephone;
        $userInformation['adresse']=$request->adresse;

        return $userInformation;
    }
}

if(!function_exists('patientLastName')) {
    function patientLastName($consultation)
    {
        return str_replace(' ','_',ucfirst($consultation->dossier->patient->user->nom));
    }
}
if(!function_exists('patientFirstName')) {
    function patientFirstName($consultation)
    {
        return ucfirst(is_null($consultation->dossier->patient->user->prenom) ? '' :$consultation->dossier->patient->user->prenom);
    }
}


