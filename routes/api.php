<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('oauth/token', 'Api\AuthController@auth');


Route::middleware(['auth:api'])->group(function () {
    Route::get('/countries', function () {
        $countries = countries();
        return response()->json(
            [
                'countries' => $countries
            ]
        );
    });

    Route::get('auteur','Api\AuteurController@store');

});
Route::group(['middleware' => ['auth:api','role:Admin']], function () {
    Route::resource('user', 'Api\UserController')->except(['create','edit']);

    Route::get('test',function (){
        return response()->json(['slug'=>\Illuminate\Support\Str::slug('model')]);
    });
});
//        Définition des routes accéssible par le gestionnaire
Route::group(['middleware' => ['auth:api','role:Admin|Gestionnaire']], function () {
    Route::resource('etablissement','Api\EtablissementExerciceController')->except(['create','edit']);
    Route::resource('profession','Api\ProfessionController')->except(['create','edit']);
    Route::resource('specialite','Api\SpecialiteController')->except(['create','edit']);
    Route::resource('praticien','Api\PraticienController')->except(['create','edit']);
    Route::resource('medecinControle','Api\MedecinControleController')->except(['create','edit']);
    Route::resource('souscripteur','Api\SouscripteurController')->except(['create','edit']);
    Route::resource('patient','Api\PatientController')->except(['create','edit']);
    Route::resource('affiliation','Api\AffiliationController')->except(['create','edit']);
    Route::resource('dossier','Api\DossierMedicalController')->except(['create','edit']);
    Route::resource('gestionnaire','Api\GestionnaireController')->except(['create','edit']);

//        Route pour ajouter ou supprimer les etablissement d'un praticien
    Route::post('praticien/add/etablissement','Api\PraticienController@addEtablissement');
    Route::post('praticien/delete/etablissement','Api\PraticienController@removeEtablissement');
});

//    Définition des routes accéssible par le praticien
Route::group(['middleware' => ['auth:api','role:Admin|Praticien']], function () {
    Route::resource('praticien','Api\PraticienController')->only('show');
    Route::put('resultat/{id}/transmettre','Api\ResultatController@transmettre');
    Route::put('consultationMedecine/{id}/transmettre','Api\ConsultationMedecineGeneraleController@transmettre');
    Route::put('consultationObstetrique/{id}/transmettre','Api\ConsultationObstetriqueController@transmettre');
    Route::put('consultationPrenatale/{id}/transmettre','Api\ConsultationPrenantaleController@transmettre');

});

//    Définition des routes accéssible par le souscripteur
Route::group(['middleware' => ['auth:api','role:Admin|Souscripteur']], function () {
    Route::resource('souscripteur','Api\SouscripteurController')->only('show');

});

//    Définition des routes accéssible par le medecin controle
Route::group(['middleware' => ['auth:api','role:Admin|Medecin controle']], function () {
    Route::resource('medecinControle','Api\MedecinControleController')->only('show');
    Route::put('resultat/{id}/archiver','Api\ResultatController@archiver');
    Route::put('consultationMedecine/{id}/archiver','Api\ConsultationMedecineGeneraleController@archiver');
    Route::put('consultationObstetrique/{id}/archiver','Api\ConsultationObstetriqueController@archiver');
    Route::put('consultationPrenatale/{id}/archiver','Api\ConsultationPrenantaleController@archiver');
});

//    Définition des routes accéssible par le patient
Route::group(['middleware' => ['auth:api','role:Admin|Patient']], function () {

});

//  Définition des routes accéssible a la fois par le patient, le medecin controle et le souscripteur
Route::group(['middleware' => ['auth:api','role:Admin|Patient|Medecin controle|Souscripteur']], function () {
    Route::resource('affiliation','Api\AffiliationController')->only('show');

});
Route::group(['middleware' => ['auth:api','role:Admin|Gestionnaire|Patient|Medecin controle|Souscripteur|Praticien']], function () {
    Route::resource('patient','Api\PatientController')->only(['show']);

});
//  Définition des routes accéssible a la fois par le patient, le medecin controle, le souscripteur et le praticien
Route::group(['middleware' => ['auth:api','role:Admin|Patient|Medecin controle|Souscripteur|Praticien']], function () {
    Route::resource('dossier','Api\DossierMedicalController')->only('show');
    Route::resource('consultationMedecine','Api\ConsultationMedecineGeneraleController')->only('show');
    Route::resource('consultationObstetrique','Api\ConsultationObstetriqueController')->only('show');
    Route::resource('motif','Api\MotifController')->only('show');
    Route::resource('allergie','Api\AllergieController')->only('show');
    Route::resource('antecedent','Api\AntecedentController')->only('show');
    Route::resource('traitement','Api\TraitementController')->only('show');
    Route::resource('parametreCommun','Api\ParametreCommunController')->only('show');
    Route::resource('conclusion','Api\ConclusionController')->only('show');
    Route::resource('resultat','Api\ResultatController')->only('show');
    Route::resource('examenClinique','Api\ExamenCliniqueController');
    Route::resource('examenComplementaire','Api\ExamenComplementaireController')->only('show');
    Route::resource('consultationMedecine','Api\ConsultationMedecineGeneraleController')->only('show');
    Route::resource('consultationObstetrique','Api\ConsultationObstetriqueController')->only('show');
    Route::resource('consultationPrenatale','Api\ConsultationPrenantaleController')->only('show');
    Route::resource('parametreObstetrique','Api\ParametreObstetriqueController')->only('show');
    Route::resource('echographie','Api\EchographieController')->only('show');
    Route::resource('hospitalisation','Api\HospitalisationController')->only('show');


});

//  Définition des routes accéssible a la fois par le medecin controle et le praticien
Route::group(['middleware' => ['auth:api','role:Admin|Medecin controle|Praticien']], function () {
    Route::resource('consultationMedecine','Api\ConsultationMedecineGeneraleController')->except(['create','edit']);
    Route::resource('consultationObstetrique','Api\ConsultationObstetriqueController')->except(['create','edit']);
    Route::resource('motif','Api\MotifController')->except(['create','edit']);
    Route::resource('allergie','Api\AllergieController')->except(['create','edit']);
    Route::resource('antecedent','Api\AntecedentController')->except(['create','edit']);
    Route::resource('traitement','Api\TraitementController')->except(['create','edit']);
    Route::resource('parametreCommun','Api\ParametreCommunController')->except(['create','edit']);
    Route::resource('conclusion','Api\ConclusionController')->except(['create','edit']);
    Route::resource('resultat','Api\ResultatController')->except(['create','edit']);
    Route::resource('examenClinique','Api\ExamenCliniqueController')->except(['create','edit']);
    Route::resource('examenComplementaire','Api\ExamenComplementaireController')->except(['create','edit']);
    Route::resource('consultationMedecine','Api\ConsultationMedecineGeneraleController')->except(['create','edit']);
    Route::resource('consultationObstetrique','Api\ConsultationObstetriqueController')->except(['create','edit']);
    Route::resource('consultationPrenatale','Api\ConsultationPrenantaleController')->except(['create','edit']);
    Route::resource('parametreObstetrique','Api\ParametreObstetriqueController')->except(['create','edit']);
    Route::resource('echographie','Api\EchographieController')->except(['create','edit']);
    Route::resource('hospitalisation','Api\HospitalisationController')->except(['create','edit']);

    Route::post('removeMotif','Api\ConsultationMotifController@removeMotif');
    Route::post('ajouterMotif','Api\ConsultationMotifController@ajouterMotif');

    Route::post('retirerExamenClinique','Api\ConsultationExamenCliniqueController@retirerExamenClinique');
    Route::post('ajouterExamenClinique','Api\ConsultationExamenCliniqueController@ajouterExamenClinique');

    Route::post('retirerExamenComplementaire','Api\ConsultationExamenComplentaireController@retirerExamenComplementaire');
    Route::post('ajouterExamenComplementaire','Api\ConsultationExamenComplentaireController@ajouterExamenComplementaire');

    Route::post('ConsultationPrenantale/retirerExamenClinique','Api\ConsultPrenExamClinController@retirerExamenClinique');
    Route::post('ConsultationPrenantale/ajouterExamenClinique','Api\ConsultPrenExamClinController@ajouterExamenClinique');

    Route::post('ConsultationPrenantale/retirerExamenComplementaire','Api\ConsultPrenExamComController@retirerExamenComplementaire');
    Route::post('ConsultationPrenantale/ajouterExamenComplementaire','Api\ConsultPrenExamComController@ajouterExamenComplementaire');

    Route::post('Hospitalisation/retirerExamenClinique','Api\HospitalisationExamClinController@retirerExamenClinique');
    Route::post('Hospitalisation/ajouterExamenClinique','Api\HospitalisationExamClinController@ajouterExamenClinique');

    Route::post('Hospitalisation/retirerExamenComplementaire','Api\HospitalisationExamComController@retirerExamenComplementaire');
    Route::post('Hospitalisation/ajouterExamenComplementaire','Api\HospitalisationExamComController@ajouterExamenComplementaire');

    Route::post('retirerAllergie','Api\ConsultationAllergieController@retirerAllergie');
    Route::post('ajouterAllergie','Api\ConsultationAllergieController@ajouterAllergie');

    Route::post('retirerTraitement','Api\ConsultationTraitementController@retirerTraitement');
    Route::post('ajouterTraitement','Api\ConsultationTraitementController@ajouterTraitement');
});


