<?php

use App\Models\Dictionnaire;
use Psy\Util\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/* header('Access-Control-Allow-Origin:  Accept');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE, PATCH');
header('Access-Control-Allow-Headers:  Origin, Content-Type, X-Auth-Token, Authorization, X-Requested-With, x-xsrf-token, x-csrf-token');

 */
/*
|---------------------  -----------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('oauth/token', 'Api\AuthController@auth');
Route::post('oauth/redirect/token', 'Api\AuthController@authAfterRedirect');

Route::post('password/emailVersion', 'Auth\ForgotPasswordController@sendReset_LinkEmail');
Route::post('password/emailVersion/mobile', 'Auth\ForgotPasswordController@mobileMail');
Route::post('password/smsVersion', 'Api\PatientController@resetPassword');
Route::post('password/reset', 'Api\UserController@reset');
Route::get('question', 'Api\QuestionController@index');
Route::resource('user-show', 'Api\UserController');
Route::resource("v2/groupes", 'Api\v2\Globale\GroupeUtilisateurController')->middleware('auth:api');
Route::get("v2/roles/groupes", 'Api\v2\Globale\RoleController@groupesRoles')->middleware('auth:api');

// Pour faire rapidement les tests sur suivi en back avec postman
//Route::resource('avis','Api\AvisController');
//Route::post('avisMedecin/{slug}','Api\AvisMedecinController@store');
//Route::resource('suivi','Api\SuiviController');
//    Route::resource('consultation-kinesitherapie','Api\KinesitherapieController');
//    Route::put('consultation-kinesitherapie/{slug}/transmettre','Api\KinesitherapieController@transmettre');
//    Route::put('consultation-kinesitherapie/{slug}/archiver','Api\KinesitherapieController@archiver');
//    Route::put('consultation-kinesitherapie/{slug}/reactiver','Api\KinesitherapieController@reactiver');
//Route::resource('partenaire','Api\PartenaireController');

Route::get('impression/facture-offre/{commande_id}', function ($commande_id) {

    return response()->json(['link' => route('facture.offre', $commande_id)]);
});
// Route::get('visualiser-consultation-medecine/{slug}', function ($slug) {

//     return response()->json(['link' => route('visualiser.consultation', $slug)]);
// });
Route::get('visualiser-consultation-medecine/{slug}', 'Api\ImprimerController@visualiser');

Route::resource('dictionnaire', 'Api\DictionnaireController')->only('show');
Route::resource('contact_assurances', 'Api\ContactAssuranceController');
// Route::get('/liens', function () {
//     $liens = Dictionnaire::where("reference", "lien_parente")->get();
//     return response()->json(
//         [
//             'liens' => $liens
//         ]
//     );
// });
Route::get('/liens', [LiensController::class, 'index']);
Route::middleware(['auth:api'])->group(function () {

    Route::get('/countries', function () {
        $countries = collect(countries());
        return response()->json(
            [
                'countries' => $countries->sortBy('name')
            ]
        );
    });

    Route::post('/logout', 'Api\UserController@logout');
    Route::post('/signature/user', 'Api\UserController@signature');
});

//super Admin route
// Route::group(['middleware' => ['auth:api','role:Super Admin']], function () {
//     Route::resource('user', 'Api\UserController')->except(['create','edit']);
// });

Route::group(['middleware' => ['auth:api', 'role:Admin']], function () {
    Route::resource('user', 'Api\UserController')->except(['create', 'edit']);
    Route::get('users', 'Api\UserController@getUserWithPermissions');
    Route::get('one-user/{slug}', 'Api\UserController@getOneUser');
    // getOneUser
});
//        Définition des routes accéssible par le gestionnaire
Route::group(['middleware' => ['auth:api', 'role:Admin|Gestionnaire|Assistante|Pharmacien|Souscripteur']], function () {
    Route::resource('etablissement', 'Api\EtablissementExerciceController')->except(['create', 'edit']);
    Route::get('findEtablissement/{etablissement}', 'Api\EtablissementExerciceController@findEtablissement');
    Route::resource('profession', 'Api\ProfessionController')->except(['create', 'edit']);
    Route::resource('praticien', 'Api\PraticienController')->except(['create', 'edit']);
    Route::resource('medecin-controle', 'Api\MedecinControleController')->except(['create', 'edit']);
    //    Route::resource('souscripteur','Api\SouscripteurController')->except(['create','edit']);

    Route::resource('dossier', 'Api\DossierMedicalController')->except(['create', 'edit']);
    Route::resource('gestionnaire', 'Api\GestionnaireController')->except(['create', 'edit']);

    //        Route pour ajouter ou supprimer les etablissement d'un praticien
    Route::post('praticien/add-etablissement', 'Api\PraticienController@addEtablissement');
    Route::post('praticien/delete-etablissement', 'Api\PraticienController@removeEtablissement');
    Route::post('medecin-controle/add-etablissement', 'Api\MedecinControleController@addEtablissement');
    Route::post('medecin-controle/delete-etablissement', 'Api\MedecinControleController@removeEtablissement');

    //        Route pour ajouter ou supprimer les etablissement d'un praticien
    Route::post('etablissement/delete-patient', 'Api\EtablissementPatientController@retirerPatientAEtablissement');

    Route::post('etablissement/{etablissement}', 'Api\EtablissementExerciceController@update')->name('etablissement.info.update');

    Route::post('medecin-controle/{medecin}', 'Api\MedecinControleController@update')->name('medecin.controle.update');
    Route::post('praticien/{praticien}', 'Api\PraticienController@update')->name('praticien.post.update');
    /**
     * recuperer les medecins d'un établissement précis médécin controle et praticien     */
    Route::get('praticien_medecin-controle/{etablissement}/etablissement', 'Api\MedecinControleController@getMedecinEtablissement');
});

//    Définition des routes accéssible par le praticien
Route::group(['middleware' => ['auth:api', 'role:Admin|Praticien|Medecin controle|Assistante|Souscripteur|Pharmacien']], function () {
    Route::put('resultat-labo/{id}/transmettre', 'Api\ResultatLaboController@transmit');
    Route::put('resultat-labo/{id}/transmettre', 'Api\ResultatLaboController@transmit');
    Route::put('consultation-fichier/{id}/transmettre', 'Api\ConsultationFichierController@transmettre');
    Route::put('consultation-medecine/{id}/transmettre', 'Api\ConsultationMedecineGeneraleController@transmettre');
    Route::post('consultation-medecine/{slug}', 'Api\ConsultationMedecineGeneraleController@update');
    Route::post('consultation-fichier/{slug}', 'Api\ConsultationFichierController@update');
    Route::post('consultation-cardiologie/{slug}', 'Api\CardiologieController@update');
    Route::post('consultation-kinesitherapie/{slug}', 'Api\KinesitherapieController@update');
    Route::put('consultation-kinesitherapie/{slug}/transmettre', 'Api\KinesitherapieController@transmettre');
    Route::put('consultation-cardiologie/{slug}/transmettre', 'Api\CardiologieController@transmettre');
    Route::put('consultation-obstetrique/{id}/transmettre', 'Api\ConsultationObstetriqueController@transmettre');
    Route::put('consultation-prenatale/{id}/transmettre', 'Api\ConsultationPrenantaleController@transmettre');
    Route::put('hospitalisation/{hospitalisation}/transmettre', 'Api\HospitalisationController@transmettre');
    Route::resource('examen-cardiologie', 'Api\ExamenCardioController');
    Route::resource('groupe-activite', 'Api\GroupeActiviteController');
    Route::resource('activite', 'Api\ActiviteController');
    Route::put('activite-cloture/{slug}', 'Api\ActiviteController@cloturer');
    Route::put('activite-mission/{slug}', 'Api\ActiviteController@updateActiviteMission');
    // Route::post('activite-mission-add','Api\ActiviteController@ajouterMission');
    Route::post('/activite-ama/save', 'Api\ActiviteController@saveMissions');
    Route::post('activite-mission-add', 'Api\ActiviteController@createMissions');

    Route::get('/mission/list', 'Api\ActiviteController@getListMission');

    // Route::resource('/activite-pec','Api\PecController');
    Route::post('/activite-pec', 'Api\PecController@store');
    Route::get('/activite-pec-list', 'Api\PecController@index');
    // Route::post('/activite-pec/list','Api\PecController@index')->name('index');
    // Route::resource('activite-pec','Api\AssistanteController');
    Route::get('/chat', 'Api\ChatController@index')->name('chat');
    Route::get('/message', 'Api\MessageController@index')->name('message.index');
    Route::post('/message', 'Api\MessageController@store')->name('message.store');
    Route::post('validation/examens/etat', 'Api\ConsultationExamenValidationController@setEtatValidationMedecin');
    Route::get('examens/validations/{ligne_temps_id}/{version}/{auteur}', 'Api\ConsultationExamenValidationController@versionValidation');
    Route::get('ligne_temps/close/{id}', 'Api\LigneDeTempsController@changeEtat');
    Route::get('ligne_temps/bilan/{ligne_temps_id}', 'Api\ConsultationExamenValidationController@ligneTempsBilan');
    Route::get('bilans/financiers/{patient}', 'Api\ConsultationExamenValidationController@BilanFinancier');
    Route::get('fiche/signalitique/{patient}', 'Api\ConsultationExamenValidationController@FicheSignalitique'); // lll

    Route::get('bilans/globale/{dossier}/financiers', 'Api\ConsultationExamenValidationController@bilanGlobalFiancier');
    Route::post('validation/examens/souscripteur', 'Api\ConsultationExamenValidationController@setEtatValidationSouscripteur');
    Route::delete('activite-mission-delete/{slug}', 'Api\ActiviteController@supprimerMission');
    Route::get('show-groupe-activite/{slug}', 'Api\ActiviteController@showGroupActivities');
    Route::get('activite-ama/patient/{id}', 'Api\ActiviteController@getMissionAma');
});


//    Définition des routes accéssible par le medecin controle
Route::group(['middleware' => ['auth:api', 'role:Admin|Medecin controle|Assistante|Souscripteur|Pharmacien']], function () {
    Route::resource('partenaire', 'Api\PartenaireController');
    Route::put('resultat-labo/{resultat}/archiver', 'Api\ResultatLaboController@archive');
    Route::put('consultation-fichier/{resultat}/archiver', 'Api\ConsultationFichierController@archiver');
    Route::put('hospitalisation/{hospitalisation}/archiver', 'Api\HospitalisationController@archiver');
    Route::put('resultat-imagerie/{resultat}/archiver', 'Api\ResultatImagerieController@archive');
    Route::put('consultation-medecine/{consultation_medecine}/archiver', 'Api\ConsultationMedecineGeneraleController@archiver');
    Route::put('consultation-obstetrique/{consultation_obstetrique}/archiver', 'Api\ConsultationObstetriqueController@archiver');
    Route::put('consultation-prenatale/{consultation_prenatale}/archiver', 'Api\ConsultationPrenantaleController@archiver');
    Route::put('ordonance/{ordonance}/archiver', 'Api\OrdonanceController@archiver');
    Route::put('consultation-kinesitherapie/{slug}/archiver', 'Api\KinesitherapieController@archiver');
    Route::put('consultation-cardiologie/{slug}/archiver', 'Api\CardiologieController@archiver');
    Route::put('consultation-cardiologie/{slug}/reactiver', 'Api\CardiologieController@reactiver');
    Route::put('consultation-kinesitherapie/{slug}/reactiver', 'Api\KinesitherapieController@reactiver');
    Route::put('consultation-medecine/{id}/reactiver', 'Api\ConsultationMedecineGeneraleController@reactiver');
    Route::put('consultation-obstetrique/{id}/reactiver', 'Api\ConsultationObstetriqueController@reactiver');
    Route::put('consultation-fichier/{id}/reactiver', 'Api\ConsultationFichierController@reactiver');
});

//    Définition des routes accéssible par le patient
Route::group(['middleware' => ['auth:api', 'role:Admin|Patient|Souscripteur|Assistante|Medecin controle']], function () {
    Route::resource('consultation-obstetrique', 'Api\ConsultationObstetriqueController')->only('show', 'index');
    Route::get('{patient}/dossier-medical', 'Api\DossierMedicalController@dossierByPatientId');
    Route::put('/secretReset/{slug}', 'Api\ReponseSecreteController@update');
    Route::get('consentement/{souscripteur_slug}/{patient_slug}', 'Api\UserController@consentement');
});

//  Définition des routes accéssible a la fois par le medecin controle et le praticien
Route::group(['middleware' => ['auth:api', 'role:Admin|Medecin controle|Praticien|Assistante|Souscripteur|Pharmacien']], function () {
    Route::resource('etablissement', 'Api\EtablissementExerciceController')->except(['create', 'store', 'destroy', 'edit']);
    Route::resource('consultation-medecine', 'Api\ConsultationMedecineGeneraleController')->except(['create', 'edit']);
    Route::resource('consultation-obstetrique', 'Api\ConsultationObstetriqueController')->except(['create', 'edit']);
    Route::resource('consultation-cardiologie', 'Api\CardiologieController')->except(['create', 'edit']);
    Route::resource('consultation-cardiologie', 'Api\CardiologieController')->except(['create', 'edit']);
    Route::resource('consultation-kinesitherapie', 'Api\KinesitherapieController');
    Route::resource('motif', 'Api\MotifController')->except(['create', 'edit']);
    Route::resource('allergie', 'Api\AllergieController')->except(['create', 'edit']);
    Route::resource('antecedent', 'Api\AntecedentController')->except(['create', 'edit']);
    //    Route::resource('traitement','Api\TraitementController')->except(['create','edit']);
    Route::resource('traitement-actuel', 'Api\TraitementActuelController')->except(['create', 'edit']);
    Route::resource('traitement-propose', 'Api\TraitementProposeController')->except(['create', 'edit']);
    Route::resource('parametre-commun', 'Api\ParametreCommunController')->except(['create', 'edit']);
    Route::resource('conclusion', 'Api\ConclusionController')->except(['create', 'edit']);
    Route::resource('resultat-labo', 'Api\ResultatLaboController')->except(['create', 'edit', 'update']);
    Route::resource('resultat-imagerie', 'Api\ResultatImagerieController')->except(['create', 'edit', 'update']);
    Route::post('resultat-labo/{resultat}', 'Api\ResultatLaboController@update')->name('resultat.labo.update');
    Route::post('resultat-imagerie/{resultat}', 'Api\ResultatImagerieController@update')->name('resultat.imagerie.update');
    Route::resource('consultation-prenatale', 'Api\ConsultationPrenantaleController')->except(['create', 'edit']);
    Route::resource('parametre-obstetrique', 'Api\ParametreObstetriqueController')->except(['create', 'edit']);
    Route::resource('echographie', 'Api\EchographieController')->except(['create', 'edit']);
    Route::resource('hospitalisation', 'Api\HospitalisationController')->except(['create', 'edit']);
    Route::resource('consultation-fichier', 'Api\ConsultationFichierController')->except('create', 'edit');

    Route::post('consultation-medecine-motif/retirer-motif', 'Api\ConsultationMotifController@removeMotif');
    Route::post('consultation-medecine-motif/ajouter-motif', 'Api\ConsultationMotifController@ajouterMotif');

    Route::post('hospitalisation/ajouter-motif', 'Api\HospitalisationMotifController@ajouterMotif');
    Route::post('hospitalisation/retirer-motif', 'Api\HospitalisationMotifController@removeMotif');

    Route::post('retirer-allergie', 'Api\DossierAllergieController@retirerAllergie');
    Route::post('ajouter-allergie', 'Api\DossierAllergieController@ajouterAllergie');
    Route::post('ajouter-allergie-version', 'Api\DossierAllergieController@ajouterAllergieVersionDeux');

    Route::post('retirer-traitement', 'Api\ConsultationTraitementController@retirerTraitement');
    Route::post('ajouter-traitement', 'Api\ConsultationTraitementController@ajouterTraitement');

    Route::get('max-consultation-obs', 'Api\ConsultationObstetriqueController@genererNumeroGrossesse');

    Route::get('latest-operation', 'Api\AuteurController@latestOperation');

    Route::resource('categorie', 'Api\CategorieController');
    Route::resource('suivi', 'Api\SuiviController');
    Route::get('suivi/search/{value}', 'Api\SuiviController@search')->name('suivi.search');
    Route::resource('toDoList', 'Api\ToDoListController');
    Route::post('toDoList/{slug}/statut', 'Api\ToDoListController@updateStatut');
    Route::resource('suivi-specialite', 'Api\SpecialiteSuiviController');
    Route::post('suivi-specialites/delete', 'Api\SpecialiteSuiviController@deleteAllSpecialities');
    Route::resource('avis', 'Api\AvisController');
    Route::post('avisMedecin/{slug}', 'Api\AvisMedecinController@store');
    Route::get('avisMedecin/{slug}', 'Api\AvisMedecinController@show');
    Route::get('avis/patient/{dossier}', 'Api\AvisMedecinController@getAvisFromDossier');
    Route::delete('avisMedecin/{slug}', 'Api\AvisMedecinController@destroy');
    Route::get('avis-repondre/{avis}', 'Api\AvisMedecinController@repondre');
    Route::post('avisMedecin/{slug}/nouveauAvis', 'Api\AvisMedecinController@NouveauAvis');
    Route::apiResource('compte-rendu-operatoire', 'Api\CompteRenduOperatoireController')->except('show');
    Route::put('compte-rendu-operatoire/{compte}/transmettre', 'Api\CompteRenduOperatoireController@transmettre');
    Route::put('compte-rendu-operatoire/{compte}/archiver', 'Api\CompteRenduOperatoireController@archiver');
    Route::put('compte-rendu-operatoire/{compte}/reactivier', 'Api\CompteRenduOperatoireController@reactiver');

    Route::get('commandes-attentes', 'Api\AffiliationSouscripteurController@CommandeAttentes');
});
//  Définition des routes accéssible a la fois par le patient, le medecin controle, le souscripteur et le praticien

Route::post('/commande-restante/add/{id}', 'Api\AffiliationSouscripteurController@addAffiliationRestante');
Route::group(['middleware' => ['auth:api', 'role:Admin|Patient|Medecin controle|Souscripteur|Praticien|Assistante|Pharmacien']], function () {
    //    Route::resource('dictionnaire','Api\DictionnaireController')->only('show');
    Route::resource('affiliation', 'Api\AffiliationController')->except(['create', 'edit', 'show']);
    Route::get('affiliation/souscripteur/{id}', 'Api\AffiliationController@affiliateBySouscripteur');
    // Route::get('affiliation/suspendre/{id}','Api\AffiliationController@stateSuspend');
    Route::post('affiliation-status', 'Api\AffiliationController@updateStatus');
    // getLastestAffiliation
    Route::post('/contrat-prepaye-store-patient', 'Api\AffiliationSouscripteurController@storePatient');
    Route::post('/contrat-prepaye-store-affiliation', 'Api\AffiliationSouscripteurController@addExistingAffiliation');
    Route::post('/contrat-prepaye-store-patient-unpaid', 'Api\AffiliationSouscripteurController@storePatientBeforePayment');
    Route::get('/commande-restante/{id}', 'Api\AffiliationSouscripteurController@affiliationRestante');
    Route::get('/get-commande-from-cim', 'Api\AffiliationSouscripteurController@getSouscripteurFromCIM');
    // Route::resource('rdvs','Api\RendezVousController');

    /**
     * recherche d'un établisseùent
     */
    Route::get('search/etablissements/{etablissement}', 'Api\EtablissementExerciceController@search');

    Route::resource('consultation-medecine', 'Api\ConsultationMedecineGeneraleController')->except('store', 'update', 'destroy');
    Route::resource('consultation-kinesitherapie', 'Api\KinesitherapieController')->except('store', 'update', 'destroy');
    Route::resource('consultation-cardiologie', 'Api\CardiologieController')->except(['store', 'update', 'destroy']);
    Route::resource('consultation-obstetrique', 'Api\ConsultationObstetriqueController')->except('store', 'update', 'destroy');
    Route::resource('motif', 'Api\MotifController')->except('store', 'update', 'destroy');
    Route::get('search/motif/{motif}', 'Api\MotifController@search');
    Route::resource('allergie', 'Api\AllergieController')->except('store', 'update', 'destroy');
    Route::resource('antecedent', 'Api\AntecedentController')->except('store', 'update', 'destroy');
    Route::resource('traitement-actuel', 'Api\TraitementActuelController')->except('store', 'update', 'destroy');
    Route::resource('traitement-propose', 'Api\TraitementProposeController')->except('store', 'update', 'destroy');
    Route::resource('parametre-commun', 'Api\ParametreCommunController')->except('store', 'update', 'destroy');
    Route::resource('conclusion', 'Api\ConclusionController')->except('store', 'update', 'destroy');
    Route::resource('resultat-labo', 'Api\ResultatLaboController')->except('store', 'update', 'destroy');
    Route::resource('resultat-imagerie', 'Api\ResultatImagerieController')->except('store', 'update', 'destroy');
    Route::put('resultat-imagerie/{id}/transmettre', 'Api\ResultatImagerieController@transmit')->name('imagerie.transmettre');
    Route::resource('consultation-prenatale', 'Api\ConsultationPrenantaleController')->except('store', 'update', 'destroy');
    Route::resource('parametre-obstetrique', 'Api\ParametreObstetriqueController')->except('store', 'update', 'destroy');
    Route::resource('echographie', 'Api\EchographieController')->except('store', 'update', 'destroy');
    Route::resource('hospitalisation', 'Api\HospitalisationController')->except('store', 'update', 'destroy');
    Route::resource('consultation-fichier', 'Api\ConsultationFichierController')->except('store', 'update', 'destroy');
    Route::get('compte-rendu-operatoire/{compte_rendu_operatoire}', 'Api\CompteRenduOperatoireController@show');
    Route::get('user-details', 'Api\AuthController@userDetails');
    Route::get('validation/examens', 'Api\ConsultationExamenValidationController@index');
    Route::get('validation/examens/count', 'Api\ConsultationExamenValidationController@getCountInvalidation');
    Route::get('validation/examens/souscripteur', 'Api\ConsultationExamenValidationController@getExamenValidationSouscripteur');
    Route::get('validation/examens/consultation/{consultation}', 'Api\ConsultationExamenValidationController@getListExamenToValidate');
});

Route::group(['middleware' => ['auth:api', 'role:Admin|Gestionnaire|Praticien|Assistante|Medecin controle|Pharmacien|Souscripteur']], function () {
    Route::get('/get-commande-from-cim', 'Api\AffiliationSouscripteurController@getSouscripteurFromCIM');
    Route::resource('resultat-imagerie', 'Api\ResultatImagerieController');
    Route::resource('resultat-labo', 'Api\ResultatLaboController');
});

Route::group(['middleware' => ['auth:api', 'role:Admin|Medecin controle|Praticien|Gestionnaire|Patient|Souscripteur|Etablissement|Assistante|Pharmacien']], function () {
    Route::resource('dossier', 'Api\DossierMedicalController')->except('store', 'update', 'destroy');
    Route::resource('medecin-patient', 'Api\PatientMedecinController');
    Route::post("transfert-patient-medecin-referent", "Api\PatientMedecinController@transfertPatientFromOneMedecinToAnother");
    Route::get('recuperation-patients/{medecin_control_id}', "Api\PatientMedecinController@getPatients");
    Route::get('dossiers-mes-patient', 'Api\DossierMedicalController@dossierMyPatient');
    Route::get('dossiers-mes-patient/search/{value}', 'Api\DossierMedicalController@dossierMyPatientSpecial')->name('dossiers-mes-patient.dossierMyPatientSpecial');
    Route::get('imprimer-dossier/{dossier}', 'Api\ImprimerController@dossier');
    Route::get('imprimer-facture-definitive/{facture}', 'Api\ImprimerController@factureDefinitive');
    Route::get('imprimer-facture-avis-definitive/{facture}', 'Api\ImprimerController@factureAvisDefinitive');
    Route::get('imprimer-compte-rendu/{compte}', 'Api\ImprimerController@compteRendu');
    Route::get('imprimer-facture-proforma/{facture}', 'Api\ImprimerController@factureProforma');
    Route::get('imprimer-consultation-medecine/{generale}', 'Api\ImprimerController@generale');

    //    Route::get('imprimer-consultation-fichier/{fichier}','Api\ImprimerController@manuscrit');
    Route::get('imprimer-consultation-cardiologie/{cardiologie}', 'Api\ImprimerController@cardiologie');
    Route::get('imprimer-rapport-hospitalisation/{hospitalisation}', 'Api\ImprimerController@hospitalisation');
    Route::get('imprimer-rapport-kinesitherapie/{kinesitherapie}', 'Api\ImprimerController@kinesitherapie');
    Route::get('affiliationRevue/{affiliation}', 'Api\AffiliationController@show');
    Route::get('affiliationRevueEdit/{affiliation}', 'Api\AffiliationController@edit');
    Route::post('affiliationRevueUpdate/{affiliation}', 'Api\AffiliationController@update');
    Route::get('patient/{patient}', 'Api\PatientController@show')->name('patient.show');
    Route::get('patient', 'Api\PatientController@index')->name('patient.index');
    Route::get('patient/search/{value}', 'Api\PatientController@specialList')->name('patient.specialList');
    Route::get('patient/doctor/{value}', 'Api\PatientController@PatientsDoctor')->name('patient.PatientsDoctor');
    Route::get('count_patient/doctor/{value}', 'Api\PatientController@CountPatientsDoctor')->name('patient.CountPatientsDoctor');
    Route::get('patient/doctor/{value}/{limit}', 'Api\PatientController@FirstPatientsDoctor')->name('patient.FirstPatientsDoctor');
    Route::get('patient/doctor/{value}/{limit}/{page}', 'Api\PatientController@NextPatientsDoctor')->name('patient.NextPatientsDoctor');
    Route::get('souscripteur/{souscripteur}', 'Api\SouscripteurController@show')->name('souscripteur.show');
    Route::get('souscripteur/rappel/{souscripteur}', 'Api\SouscripteurController@rappelAffilie');
    Route::get('souscripteur/list/cim', 'Api\SouscripteurController@cim');
    Route::resource('etablissement', 'Api\EtablissementExerciceController')->except(['create', 'store', 'destroy', 'edit']);
    Route::get('user-etablissements', 'Api\EtablissementExerciceController@userEtablissements');
    Route::post('update-password', 'Api\UserController@updatePassword');
    Route::put('update-user/{slug}', 'Api\UserController@update');
    Route::resource('facture', 'Api\FactureController')->only('show');
});

Route::group(['middleware' => ['auth:api', 'role:Admin|Gestionnaire|Medecin controle|Etablissement|Assistante|Souscripteur|Pharmacien']], function () {
    Route::post('import_csv', 'Api\CsvFileController@csv_import');
    Route::resource('categorie-prestation', 'Api\CategoriePrestationController');
    Route::resource('etablissement-prestation', 'Api\EtablissementPrestationController');
    Route::resource('prestation', 'Api\PrestationController');
    Route::resource('facture', 'Api\FactureController')->except('show');
    Route::post('facture-recouvrement/{facture}', 'Api\FactureController@mailRecouvrement');
    Route::post('facture-rappel/{facture}', 'Api\FactureController@rappel');
    Route::resource('facture-prestation', 'Api\FacturePrestationController');
    Route::put('valider-prestation/{slug}', 'Api\FacturePrestationController@valider');
    Route::put('rejeter-prestation/{slug}', 'Api\FacturePrestationController@rejeter');
    Route::resource('comptable', 'Api\ComptableController');
    Route::resource('assistante', 'Api\AssistanteController');
    Route::resource('pharmacien', 'Api\PharmacienController');
    Route::resource('role', 'Api\RoleController');
    Route::get('timelines/{slug}/patient', 'Api\LigneDeTempsController@listingPatient');
});
Route::post('medsurlink-contrat', 'Api\PatientController@medicasureStorePatient');
// Route::post('medsurlink-contrat','Api\PatientController@medicasureStorePatient');

/**
 * Parcours de soins
 */

Route::prefix('v1')->middleware(['auth:api', 'role:Admin|Gestionnaire|Praticien|Medecin controle|Assistante|Souscripteur|Patient|Pharmacien'])->group(function () {
    Route::get('/parcours/{dossier_medical_slug}/affiliations', 'Api\v1\ParcourDeSoinController@affiliations');
    Route::get('/parcours/{dossier_medical_slug}/activite_amas', 'Api\v1\ParcourDeSoinController@activite_amas');
    Route::get('/parcours/{dossier_medical_slug}/activite_medecin_referents', 'Api\v1\ParcourDeSoinController@activite_medecin_referents');
    Route::get('/dashboard', 'Api\v1\DashboardController@dashboard');
    Route::resource('allergies', 'Api\v1\AllergieController');
    Route::resource('antecedents', 'Api\v1\AntecedentController');
    Route::get('/consultationsMedecines/{dossier_slug}', 'Api\v1\DossierMedicalController@consultationsMedecines');
    Route::resource('traitement-actuels', 'Api\v1\TraitementActuelController');
    Route::resource('type-operations', 'Api\v1\TypeOperationController');
    Route::resource('metriques', 'Api\v1\MetriqueController');
    Route::get('metriques/{date}/{metrique}', 'Api\v1\MetriqueController@courbe');
    Route::get('metriques/nbre_users/{metrique}/annee', 'Api\v1\MetriqueController@nbre_users');

    Route::get('/timeactivities', 'Api\PraticienController@timeActivities');

    // calculerDureeMoyenneRoles
    // timeActivities


});

Route::group(['middleware' => ['auth:api', 'role:Admin']], function () {
    Route::resource('roles', 'Api\RoleController');
    Route::resource('permissions', 'Api\PermissionController');
    Route::get('permissions-group', 'Api\PermissionController@groupePermission');
    Route::get('permissions-notnull', 'Api\PermissionController@permissionFeatureIsNull');
    // permissionFeatureIsNotNull
    Route::post('assignPermission', 'Api\RoleController@assignPermission');
    Route::post('assignFeature', 'Api\PermissionController@assignFeature');
    Route::resource('features', 'Api\FeatureController');

    Route::post('assignUserPermissions', 'Api\PermissionController@assignUserPermissions');
    Route::post('revokeUserPermissions', 'Api\PermissionController@revokeUserPermissions');
});

Route::group(['middleware' => ['auth:api', 'role:Admin|Gestionnaire|Praticien|Medecin controle|Assistante|Souscripteur|Patient|Pharmacien']], function () {
    Route::put('patient-decede/{patient}', 'Api\PatientController@decede');
    Route::post('souscripteur/assigin_patient', 'Api\PatientController@assignation_souscripteur');
    Route::get('patient-with-medecin-control', 'Api\PatientController@getPatientWithMedecin');
    Route::get('first_patient-with-medecin-control/{limit}', 'Api\PatientController@getFirstPatientWithMedecin');
    Route::get('next_patient-with-medecin-control/{limit}/{page}', 'Api\PatientController@getNextPatientWithMedecin');
    Route::get('affiliations/{patient_id}', 'Api\PatientController@getAffiliations');
    Route::get('affiliations/{affiliation_id}/ligne-de-temps', 'Api\PatientController@getAffiliationLigneDeTemps');
    // Route::get('10patient-with-medecin-control','Api\PatientController@get10PatientWithMedecin');
    // Route::get('15patient-with-medecin-control','Api\PatientController@get15PatientWithMedecin');
    // Route::get('100patient-with-medecin-control','Api\PatientController@get100PatientWithMedecin');
    Route::get('number_patient-with-medecin-control', 'Api\PatientController@getCountPatientWithMedecin');
    Route::resource('specialite', 'Api\SpecialiteController')->except(['create', 'edit']);
    Route::resource('consultation-type', 'Api\ConsultationTypeController')->except(['create', 'edit']);
    Route::resource('souscripteur', 'Api\SouscripteurController')->except('show');
    Route::get('search/souscripteurs/{souscripteur_search}', 'Api\SouscripteurController@listingSouscripteur');
    Route::get('patients/souscripteurs', 'Api\SouscripteurController@listingSouscripteurPatients');
    Route::get('search/patients/{patient_search}', 'Api\PatientController@listingPatients');
    Route::post('patient', 'Api\PatientController@store')->name('patient.store');
    //Route::post('medsurlink-contrat','Api\PatientController@medicasureStorePatient');
    Route::put('patient/{patient}', 'Api\PatientController@update')->name('patient.update');
    Route::delete('patient/{patient}', 'Api\PatientController@destroy')->name('patient.destroy');
    Route::get('patient-sans-intervention/{date}', 'Api\PatientController@ListingPatientSansIntervention')->name('patient.ListingPatientSansIntervention');
    Route::post('patient/add-etablissement', 'Api\EtablissementPatientController@ajouterPatientAEtablissement');
    Route::resource('medecin-controle', 'Api\MedecinControleController')->only(['index']);
    Route::resource('praticien', 'Api\PraticienController')->only(['index']);

    // timeActivities
    Route::get('/timeactivities', 'Api\PraticienController@timeActivities');

    Route::get('/lastestaffiliation', 'Api\AffiliationController@getLastestAffiliation');
    Route::get('/duree-moyenne', 'Api\UserController@calculerDureeMoyenneRoles');
    Route::get('/duree-moyenne-all-roles', 'Api\UserController@calculerDureeMoyenneAllRoles');

    Route::resource('association', 'Api\AssociationController');
    Route::resource('facture-avis', 'Api\FactureAvisController');
    Route::resource('medicament', 'Api\MedicamentController')->except(['edit', 'create']);
    Route::get('medicament/search/{chaineRecherche}', 'Api\MedicamentController@search')->name('rechercherMedicament');
    Route::resource('ordonance', 'Api\OrdonanceController')->except(['edit', 'create']);
    Route::put('ordonance/{ordonance}/transmettre', 'Api\OrdonanceController@transmettre');
    Route::delete('file/{file}', 'Api\FileController@destroy');
    Route::resource('financeur', 'Api\PatientSouscripteurController');
    Route::post('financeur/retirer', 'Api\PatientSouscripteurController@retirer');

    /**
     *  delai de prise en charge
     */

    // trajet patient
    Route::resource('ligne-temps', 'Api\LigneDeTempsController');
    Route::get('ligne-temps/dossier/{id}', 'Api\LigneDeTempsController@ligneDeTempsByDossier');
    Route::resource('examen-prix', 'Api\ExamenEtablissementPrixController');
    Route::post('examen-prix/etablissement/save', 'Api\ExamenEtablissementPrixController@storeMultiple');
    Route::get('patient/{id}/contrat-medicasure', 'Api\LigneDeTempsController@patientContrat');
    Route::get('trajet-patient/dossier/{id}', 'Api\LigneDeTempsController@getTrajetPatient');


    /**
     * recuperation des consultations d'une ligne de temps
     */
    Route::get('consultation_generale/ligne-temps/{ligne_temp_id}', 'Api\LigneDeTempsController@showConsultation');


    Route::get('paiement-prestation', 'Api\PaymentController@listPaiementSouscripteur');

    Route::post('/referent-activites-add', 'Api\ActivitesControleController@store');
});
Route::group(['middleware' => ['auth:api', 'role:Admin|Gestionnaire|Praticien|Medecin controle|Souscripteur|Assistante|Pharmacien']], function () {
    Route::resource('souscripteur', 'Api\SouscripteurController')->only('update');
    Route::get('examen-complementaire/etablissement/{id}', 'Api\ExamenEtablissementPrixController@getByEtablissement');
});
// store souscripteur from medicasure
Route::resource('medicasure/souscripteur', 'Api\MedicasureController');

Route::post('payment-prestation', 'Api\PaymentController@paymentPrestation');
Route::get('payment-prestation/{id}', 'Api\PaymentController@getPayment');
Route::post('payment-statut/{id}', 'Api\PaymentController@NotifierPaiement');
Route::resource('payment', 'Api\PaymentController');

Route::get('snomed-icd/map/{string}', 'Api\SnomedIcdController@find');
Route::get('anamnese', 'Api\AnamneseController@index');
Route::get('examen-clinic', 'Api\ExamenClinicController@index');
Route::get('examen-complementaire', 'Api\ExamenComplementaireController@index');

Route::get('other-complementaire', 'Api\OtherComplementaireController@index');

Route::group(['middleware' => ['auth:api', 'role:Praticien|Gestionnaire|Medecin controle|Assistante|Patient|Pharmacien']], function () {
    Route::resource('avis', 'Api\AvisController');
    Route::resource('rdvs', 'Api\RendezVousController');
    Route::get('rendez-vous-manques', 'Api\RendezVousController@rendez_vous_manques');
    Route::post('clotures/affiliation', "Api\ClotureController@store");
    Route::post('clotures/ligne-temps', "Api\ClotureController@ligne");
});

Route::resource('offres', 'Api\OffreController');

Route::prefix('paiement')->group(function () {
    //Ici nous mettons en place des routes pour initier les paiement venant d'ailleurs
    Route::post('/momo/paid', 'Api\MomoController@momoPaidByCustomer');
    Route::post('/momo/{identifiant}/{uuid}/collections/callback', 'Api\MomoController@notificationPaiement')->name('momo.notification');
    Route::post('/momo/paymentStatus', 'Api\MomoController@momoPayementStatusByCustomer');
    Route::post('/om/paid', 'Api\OmController@paiementFromMedicasure');
    //
    Route::post('/om/{identifiant}/{payToken}/notification/{tokenInfo}/', 'Api\OmController@notificationPaiement')->name('om.notification');
    Route::post('/prestation/om/{payment_id}/notification', 'Api\PaymentController@notificationPaiement')->name('prestation.om.notification');
    Route::get('/prestation/om/{pay_token}/notification', 'Api\PaymentController@statutPaiement');
    //route('prestation.om.notification', ['payment_id' => $payment->id, 'payToken' => $mp_token, 'tokenInfo' => $tokenInfo]),
    Route::get('/om/{identifiant}/{payToken}/statutPaiement/{patient?}', 'Api\OmController@statutPaiement');
    //Route::post('/om/paymentStatus','Api\OmController@statutPaiement');
    Route::post('/stripe-paiement', 'Api\StripeContrtoller@stripePaidByCustomer');
    Route::post('/stripe-paiement-medicasure', 'Api\StripeContrtoller@paiementFromMedicasure');
    Route::post('/stripe-renouvellement', 'Api\StripeContrtoller@renouvellementPaiement');
    Route::get('/stripe-paiement-success/{slug}/{token}', 'Api\StripeContrtoller@NotifierPaiement');
    Route::get('/stripe-renew-success/{slug}/{token}', 'Api\StripeContrtoller@notifRenewAndRedirectToAccount');
    Route::get('/stripe-paiement-success-return/{slug}', 'Api\StripeContrtoller@notifAndRedirectToAccount');
    Route::get('/stripe-paiement-cancel', function () {
        return response()->json(
            [
                'paiement' => "Cancel"
            ]
        );
    });
});
Route::get('/livesearch', 'Api\PatientController@searchPatients');
Route::get('/mission/list', 'Api\ActiviteController@getListMission');
Route::get('/referent-activites/list', 'Api\ActivitesMedecinReferentController@getListActivites');
