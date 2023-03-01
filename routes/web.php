<?php

use App\Events\AlerteEvent;
use App\Models\AffiliationSouscripteur;
use App\Models\CommandePackage;
use App\Models\ContratIntermediationMedicale;
use App\Models\CompteRenduOperatoire;
use App\Models\ConsultationExamenValidation;
use App\Models\ConsultationMedecineGenerale;
use App\Models\DossierMedical;
use App\Models\ExamenComplementaire;
use App\Models\ExamenEtablissementPrix;
use App\Models\LigneDeTemps;
use App\Models\MedecinControle;
use App\Models\Patient;
use App\Models\PatientSouscripteur;
use App\Models\Payment;
use App\Models\PaymentOffre;
use App\Models\RendezVous;
use App\Services\PatientService;

use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\GetRecordingsParameters;

use App\Services\TeleconsultationService;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**-- Headers --**/
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE, PATCH');
header('Access-Control-Allow-Headers:  Origin, Content-Type, X-Auth-Token, Authorization, X-Requested-With, x-xsrf-token');

Route::get('/contrat-prepaye-store/{cim_id}/redirect','Api\AffiliationSouscripteurController@storeSouscripteurRedirect');
//Route::get('/contrat-prepaye-store/{cim_id}/redirect','Api\AffiliationSouscripteurController@storeSouscripteurRedirect')->middleware('auth.basic.once');
Route::get('/redirect-mesurlink/redirect/{email}','Api\MedicasureController@storeSouscripteurRedirect');
Route::resource('medicasure/souscripteur','Api\MedicasureController');

Route::get('/', function () {
    $recordingParams = new GetRecordingsParameters();
    $recordingParams->setMeetingId(174);
    $bbb = new BigBlueButton();
    $response = $bbb->getRecordings($recordingParams);
    if ($response->getReturnCode() == 'SUCCESS') {
        return $response->getRawXml()->recordings->recording->playback->format->url;
    }
    return view('welcome');
});

Route::get('/join', function () {
    return view('welcome');
});



Route::get('/public/storage/DossierMedicale/{fileNumber}/{typeConsultation}/{consultation}/{image}/{resource?}', function ($fileNumber,$typeConsultation,$consultation,$image,$resource='') {
    $path = public_path().'/storage/DossierMedicale/'.$fileNumber.'/'.$typeConsultation.'/'.$consultation.'/'.$image.($resource ? '/'.$resource :'');
    return response()->file($path);
});

Route::get('/public/storage/{role}/{fileNumber}/{type}/{image}', function ($role,$fileNumber,$type,$image) {
    $path = public_path().'/storage/'.$role.'/'.$fileNumber.'/'.$type.'/'.'/'.$image;
    return response()->file($path);
});

Route::get('/public/storage/pdf/{fileNumber}', function ($fileNumber) {
    $path = public_path().'/storage/pdf/'.$fileNumber;
    return response()->file($path);
});

Route::get('/contrat/{id}', function ($id) {

    $cim= ContratIntermediationMedicale::find($id);
    return view('contrat',compact('cim'));
});

//Route::get('imprimer-dossier/{dossier}','Api\ImprimerController@dossier');

Route::get('imprimer/contrat/{id}', function ($id) {
    $cim = ContratIntermediationMedicale::find($id);
    $data = ['cim'=>$cim];
    $pdf = PDF::loadView('contrat_version_imprimable',$data);
    return $pdf->download("Contrat d'intermediation medicale - ".strtoupper($cim->nomPatient)." ".ucfirst($cim->prenomPatient)." - ".ucfirst($cim->typeSouscription).".pdf");
});

Route::get('/doc', function () {
    $compteRendu = CompteRenduOperatoire::whereId(2)->first();
    $data = compact('compteRendu');
    return view('rapport.compte_rendu', $data);
});
/**
 * consentement éclairé du patient
 */
Route::get('souscripteur/consentement_generate/{souscripteur_slug}/{patient_slug}', function($souscripteur_slug, $patient_slug){
    $souscripteur = User::whereSlug($souscripteur_slug)->first();
    $patient = Patient::whereSlug($patient_slug)->first();
    $patient_consentement = $patient->consentement;
    $patient_restriction = $patient->restriction;
    $patient = $patient->user;
    $patient_souscripteurs = PatientSouscripteur::where(['financable_id' => $souscripteur->souscripteur->user_id, 'patient_id' => $patient->id])->latest()->get();
    foreach($patient_souscripteurs as $patient_souscripteur){
        $patient_souscripteur->update(['souscripteur_consentement' => 1, 'patient_consentement' => $patient_consentement, 'restriction' => $patient_restriction]);
    }
    $patient_souscripteur = $patient_souscripteurs->first();
    $title = $patient_restriction  ? ' Consentement éclairé du patient "avec restrictions"' : ' Consentement éclairé du patient';
    $pdf = PDF::loadView('pdf.consentement.souscripteur', ['souscripteur' => $souscripteur, 'patient' => $patient, 'lien' => $patient_souscripteur->lien->fr_description, 'patient_consentement' => $patient_consentement, 'title' => $title]);
    return $pdf->stream("Consentement éclairé du patient.pdf");
})->name('consentement.patient');


Route::get('impression/facture-offre/{affiliation}', function ($affiliation) {

    $affiliation = AffiliationSouscripteur::find($affiliation);

    $commande_id = $affiliation->commande->id;
    $commande_date = $affiliation->commande->date_commande;
    $montant_total = $affiliation->montant;
    $echeance =  "13/02/2022";
    $description = $affiliation->typeContrat->description_fr;
    $quantite =  $affiliation->commande->quantite;
    $prix_unitaire = $affiliation->typeContrat->montant;
    $nom_souscripteur = mb_strtoupper($affiliation->souscripteur->user->nom).' '.$affiliation->souscripteur->user->prenom;
    $email_souscripteur = $affiliation->souscripteur->user->email;
    $rue =  $affiliation->souscripteur->user->quartier;
    $adresse =  $affiliation->souscripteur->user->adresse;
    $pays =  $affiliation->souscripteur->user->pays;
    $ville = $affiliation->souscripteur->user->code_postal.' - '.$affiliation->souscripteur->user->ville;
    $beneficiaire ="FOUKOUOP NDAM Rebecca";

    $pdf = generationPdfFactureOffre($commande_id, $commande_date, $montant_total, $echeance, $description, $quantite, $prix_unitaire, $nom_souscripteur, $email_souscripteur, $rue, $adresse, $ville, $pays, $beneficiaire);
    return $pdf['stream'];
})->name('facture.offre');

Route::get('teleconsultations/print/{teleconsultation_id}', function ($teleconsultation_id) {

    $teleconsultation = new TeleconsultationService;
    $teleconsultation = json_decode($teleconsultation->fetchTeleconsultation($teleconsultation_id), true)['data'];
    $patient_id = $teleconsultation['patient_id'];

    $patient = Patient::where('user_id', $patient_id)->orWhere('slug', $patient_id)
        ->orwhereHas('dossier', function ($query) use ($patient_id) {
            $query->where('patient_id', $patient_id);
        })->orwhereHas('user', function ($query) use ($patient_id) {
            $query->where('id', $patient_id);
        })->orwhereHas('alerte', function ($query) use ($patient_id) {
            $query->where('patient_id', $patient_id);
        })->with('user:id,nom,prenom,email,telephone,slug')->first();


    $medecin = MedecinControle::withTrashed()->with(['specialite:id,name','user:id,nom,prenom,email'])->where('user_id', $teleconsultation['creator'])->get(['specialite_id', 'user_id', 'civilite', 'numero_ordre'])->first();

    $date = Carbon::parse($teleconsultation['created_at'])->locale(config('app.locale'))->translatedFormat('jS F Y');

    $pdf = PDF::loadView('pdf.teleconsultations.rapport', ['teleconsultation' => $teleconsultation, 'patient' => $patient, 'medecin' => $medecin, 'date' => $date]);
    //return ['output' => $pdf->output(), 'stream' => $pdf->stream($description.".pdf")];

    return $pdf->stream("Téléconsultation de {$patient->user->name} du {$date} par {$medecin->civilite} {$medecin->user->name}" . ".pdf");

})->name('teleconsultations.print');


Route::get('visualiser-consultation-medecine/{slug}',function ($slug){
    $pdf = visualiser($slug);
    return $pdf;
})->name('visualiser.consultation');

// Route::get('visualiser-consultation-medecine/{slug}','Api\ImprimerController@visualiser');

Route::get('impression/prestation/{paiement_uuid}', function ($paiement_uuid) {

    $payment = Payment::where("uuid", $paiement_uuid)->first();
    $payment = $payment->load('souscripteur.user','patients.user');

    $payment_id = $payment->id;
    $commande_date = $payment->date_payment;
    $montant_total = $payment->amount;
    $echeance =  "13/02/2022";
    $description = $payment->motif;
    $mode_paiement = mb_strtoupper($payment->method) == 'OM' ? 'Orange Money' : 'Stripe' ;
    $prix_unitaire = 2;
    $nom_souscripteur = mb_strtoupper($payment->souscripteur->user->nom).' '.$payment->souscripteur->user->prenom;
    $email_souscripteur = $payment->souscripteur->user->email;
    $rue =  $payment->souscripteur->user->quartier;
    $adresse =  $payment->souscripteur->user->adresse;
    $pays =  $payment->souscripteur->user->pays;
    $ville = $payment->souscripteur->user->code_postal.' - '.$payment->souscripteur->user->ville;
    $beneficiaire = mb_strtoupper($payment->patients->user->nom).' '.$payment->patients->user->prenom;

    $pdf = generationPdfPaiementPrestation($payment_id, $commande_date, $montant_total, $echeance, $description, $mode_paiement, $nom_souscripteur, $email_souscripteur, $rue, $adresse, $ville, $pays, $beneficiaire);
    return $pdf['stream'];
})->name('facture.paiement.prestation');

Route::get('bilans/{patient}', function ($patient) {
    try {
        $dossier = DossierMedical::where('slug', $patient)->first();
        $ligne_temp_ids = LigneDeTemps::where('dossier_medical_id', $dossier->id)->get()->pluck('id');
        $examen_validations = ConsultationExamenValidation::whereIn('ligne_de_temps_id', $ligne_temp_ids)->get();

        $examen_validations = $examen_validations->transform(function ($item, $key) {
            $examen_prix = ExamenEtablissementPrix::where(['examen_complementaire_id' => $item->examen_complementaire_id, 'etablissement_exercices_id' => $item->etablissement_id])->latest()->first();
            $item->prix = $examen_prix->prix;
            $item->examen = ExamenComplementaire::find($examen_prix->examen_complementaire_id)->fr_description;
            return $item;
        });

        $total_prescription = $examen_validations->sum('prix');
        $total_medecin_controle = $examen_validations->where('etat_validation_medecin', 1)->sum('prix');
        $total_medecin_assureur = $examen_validations->where('etat_validation_souscripteur', 1)->sum('prix');
        Carbon\Carbon::setLocale('fr');
        $description = "Bilan Financier au ".Carbon\Carbon::now()->translatedFormat('l jS F Y');
        $pdf = PDF::loadView('pdf.soins.bilan_financier', ['examen_validations' => $examen_validations, 'total_prescription' => $total_prescription, 'total_medecin_controle' => $total_medecin_controle, 'total_medecin_assureur' => $total_medecin_assureur, 'description' => $description]);
        return $pdf->stream($description.".pdf");
    }catch (\Exception $exception){
        //$exception
    }
})->name('patient.bilan');

Auth::routes();


