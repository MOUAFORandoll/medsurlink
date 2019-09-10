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
    Route::post('praticien/add-etablissement','Api\PraticienController@addEtablissement');
    Route::post('praticien/delete-etablissement','Api\PraticienController@removeEtablissement');
});

//    Définition des routes accéssible par le praticien
Route::group(['middleware' => ['auth:api','role:Admin|Praticien']], function () {
    Route::resource('praticien','Api\PraticienController')->only('show');
    Route::put('resultat/{id}/transmettre','Api\ResultatController@transmettre');
    Route::put('consultation-medecine/{id}/transmettre','Api\ConsultationMedecineGeneraleController@transmettre');
    Route::put('consultation-obstetrique/{id}/transmettre','Api\ConsultationObstetriqueController@transmettre');
    Route::put('consultation-prenatale/{id}/transmettre','Api\ConsultationPrenantaleController@transmettre');

});

//    Définition des routes accéssible par le souscripteur
Route::group(['middleware' => ['auth:api','role:Admin|Souscripteur']], function () {
    Route::resource('souscripteur','Api\SouscripteurController')->only('show');

});

//    Définition des routes accéssible par le medecin controle
Route::group(['middleware' => ['auth:api','role:Admin|Medecin controle']], function () {
    Route::resource('medecin-controle','Api\MedecinControleController')->only('show');
    Route::put('resultat/{resultat}/archiver','Api\ResultatController@archiver');
    Route::put('consultation-medecine/{consultation_medecine}/archiver','Api\ConsultationMedecineGeneraleController@archiver');
    Route::put('consultation-obstetrique/{consultation_obstetrique}/archiver','Api\ConsultationObstetriqueController@archiver');
    Route::put('consultation-prenatale/{consultation_prenatale}/archiver','Api\ConsultationPrenantaleController@archiver');
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
    Route::resource('consultation-medecine','Api\ConsultationMedecineGeneraleController')->only('show');
    Route::resource('consultation-obstetrique','Api\ConsultationObstetriqueController')->only('show');
    Route::resource('motif','Api\MotifController')->only('show');
    Route::resource('allergie','Api\AllergieController')->only('show');
    Route::resource('antecedent','Api\AntecedentController')->only('show');
    Route::resource('traitement','Api\TraitementController')->only('show');
    Route::resource('parametre-commun','Api\ParametreCommunController')->only('show');
    Route::resource('conclusion','Api\ConclusionController')->only('show');
    Route::resource('resultat','Api\ResultatController')->only('show');
    Route::resource('examen-clinique','Api\ExamenCliniqueController');
    Route::resource('examen-complementaire','Api\ExamenComplementaireController')->only('show');
    Route::resource('consultation-medecine','Api\ConsultationMedecineGeneraleController')->only('show');
    Route::resource('consultation-obstetrique','Api\ConsultationObstetriqueController')->only('show');
    Route::resource('consultation-prenatale','Api\ConsultationPrenantaleController')->only('show');
    Route::resource('parametre-obstetrique','Api\ParametreObstetriqueController')->only('show');
    Route::resource('echographie','Api\EchographieController')->only('show');
    Route::resource('hospitalisation','Api\HospitalisationController')->only('show');


});

//  Définition des routes accéssible a la fois par le medecin controle et le praticien
Route::group(['middleware' => ['auth:api','role:Admin|Medecin controle|Praticien']], function () {
    Route::resource('consultation-medecine','Api\ConsultationMedecineGeneraleController')->except(['create','edit']);
    Route::resource('consultation-obstetrique','Api\ConsultationObstetriqueController')->except(['create','edit']);
    Route::resource('motif','Api\MotifController')->except(['create','edit']);
    Route::resource('allergie','Api\AllergieController')->except(['create','edit']);
    Route::resource('antecedent','Api\AntecedentController')->except(['create','edit']);
    Route::resource('traitement','Api\TraitementController')->except(['create','edit']);
    Route::resource('parametre-commun','Api\ParametreCommunController')->except(['create','edit']);
    Route::resource('conclusion','Api\ConclusionController')->except(['create','edit']);
    Route::resource('resultat','Api\ResultatController')->except(['create','edit','update']);
    Route::put('resultat/{resultat}','Api\ResultatController@update')->name('resultat.update');
    Route::resource('examen-clinique','Api\ExamenCliniqueController')->except(['create','edit']);
    Route::resource('examen-complementaire','Api\ExamenComplementaireController')->except(['create','edit']);
    Route::resource('consultation-medecine','Api\ConsultationMedecineGeneraleController')->except(['create','edit']);
    Route::resource('consultation-obstetrique','Api\ConsultationObstetriqueController')->except(['create','edit']);
    Route::resource('consultation-prenatale','Api\ConsultationPrenantaleController')->except(['create','edit']);
    Route::resource('parametre-obstetrique','Api\ParametreObstetriqueController')->except(['create','edit']);
    Route::resource('echographie','Api\EchographieController')->except(['create','edit']);
    Route::resource('hospitalisation','Api\HospitalisationController')->except(['create','edit']);

    Route::post('remove-motif','Api\ConsultationMotifController@removeMotif');
    Route::post('ajouter-motif','Api\ConsultationMotifController@ajouterMotif');

    Route::post('retirer-examen-clinique','Api\ConsultationExamenCliniqueController@retirerExamenClinique');
    Route::post('ajouter-examen-clinique','Api\ConsultationExamenCliniqueController@ajouterExamenClinique');

    Route::post('retirer-examen-complementaire','Api\ConsultationExamenComplentaireController@retirerExamenComplementaire');
    Route::post('ajouter-examen-complementaire','Api\ConsultationExamenComplentaireController@ajouterExamenComplementaire');

    Route::post('consultation-prenantale/retirer-examen-clinique','Api\ConsultPrenExamClinController@retirerExamenClinique');
    Route::post('consultation-prenantale/ajouter-examen-clinique','Api\ConsultPrenExamClinController@ajouterExamenClinique');

    Route::post('consultation-prenantale/retirer-examen-complementaire','Api\ConsultPrenExamComController@retirerExamenComplementaire');
    Route::post('consultation-prenantale/ajouter-examen-complementaire','Api\ConsultPrenExamComController@ajouterExamenComplementaire');

    Route::post('hospitalisation/retirer-examen-clinique','Api\HospitalisationExamClinController@retirerExamenClinique');
    Route::post('hospitalisation/ajouter-examen-clinique','Api\HospitalisationExamClinController@ajouterExamenClinique');

    Route::post('hospitalisation/retirer-examen-complementaire','Api\HospitalisationExamComController@retirerExamenComplementaire');
    Route::post('hospitalisation/ajouter-examen-complementaire','Api\HospitalisationExamComController@ajouterExamenComplementaire');

    Route::post('retirer-allergie','Api\ConsultationAllergieController@retirerAllergie');
    Route::post('ajouter-allergie','Api\ConsultationAllergieController@ajouterAllergie');

    Route::post('retirer-traitement','Api\ConsultationTraitementController@retirerTraitement');
    Route::post('ajouter-traitement','Api\ConsultationTraitementController@ajouterTraitement');

    Route::get('max-consultation-obs','Api\ConsultationObstetriqueController@genererNumeroGrossesse');
});


