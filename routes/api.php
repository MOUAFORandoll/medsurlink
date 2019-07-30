<?php

use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::resource('cim','Api\ContratIntermediationMedicaleController')->only('index','show','store','update','destroy');

Route::middleware(['auth:api'])->group(function () {
    Route::resource('etablissement','Api\EtablissementExerciceController');
    Route::resource('profession','Api\ProfessionController');
    Route::resource('specialite','Api\SpecialiteController');
    Route::resource('praticien','Api\PraticienController');
    Route::post('praticien/add/etablissement','Api\PraticienController@addEtablissement');
    Route::post('praticien/delete/etablissement','Api\PraticienController@removeEtablissement');
    Route::resource('medecinControle','Api\MedecinControleController');

    Route::resource('gestionnaire','Api\GestionnaireController');
    Route::resource('souscripteur','Api\SouscripteurController');
    Route::resource('affiliation','Api\AffiliationController');
    Route::resource('dossier','Api\DossierMedicalController');
    Route::resource('motif','Api\MotifController');
    Route::resource('allergie','Api\AllergieController');
    Route::resource('antecedent','Api\AntecedentController');
    Route::resource('traitement','Api\TraitementController');
    Route::resource('parametreCommun','Api\ParametreCommunController');
    Route::resource('conclusion','Api\ConclusionController');
    Route::resource('resultat','Api\ResultatController');
    Route::resource('examenClinique','Api\ExamenCliniqueController');
    Route::resource('examenComplementaire','Api\ExamenComplementaireController');
    Route::resource('consultationMedecine','Api\ConsultationMedecineGeneraleController');

    Route::group(['middleware' => ['role:Admin|Gestionnaire|Patient']], function () {
        Route::resource('patient','Api\PatientController')->except(['show']);
    });
    Route::group(['middleware' => ['role:Admin|Gestionnaire|Patient|Souscripteur|Praticien|Medecin controle']], function () {
        Route::resource('patient','Api\PatientController')->only(['show']);
    });

    Route::post('removeMotif','Api\ConsultationMotifController@removeMotif');

    Route::post('retirerExamenClinique','Api\ConsultationExamenCliniqueController@retirerExamenClinique');
    Route::post('ajouterExamenClinique','Api\ConsultationExamenCliniqueController@ajouterExamenClinique');

    Route::post('retirerExamenComplementaire','Api\ConsultationExamenComplentaireController@retirerExamenComplementaire');
    Route::post('ajouterExamenComplementaire','Api\ConsultationExamenComplentaireController@ajouterExamenComplementaire');

    Route::post('retirerAllergie','Api\ConsultationAllergieController@retirerAllergie');
    Route::post('ajouterAllergie','Api\ConsultationAllergieController@ajouterAllergie');

    Route::post('retirerTraitement','Api\ConsultationTraitementController@retirerTraitement');
    Route::post('ajouterTraitement','Api\ConsultationTraitementController@ajouterTraitement');

});

Route::post('oauth/token', 'Api\AuthController@auth');
