<?php

/**-- Headers --**/
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE, PATCH');
header('Access-Control-Allow-Headers:  Origin, Content-Type, X-Auth-Token, Authorization, X-Requested-With, x-xsrf-token');


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
Route::post('password/email','Auth\ForgotPasswordController@sendResetLinkEmail');
Route::post('password/reset','Api\UserController@reset');


Route::middleware(['auth:api'])->group(function () {
    Route::get('/countries', function () {
        $countries = countries();
        return response()->json(
            [
                'countries' => $countries
            ]
        );
    });
    Route::post('/logout','Api\UserController@logout');

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
    Route::resource('medecin-controle','Api\MedecinControleController')->except(['create','edit']);
//    Route::resource('souscripteur','Api\SouscripteurController')->except(['create','edit']);
    Route::resource('affiliation','Api\AffiliationController')->except(['create','edit','show']);
    Route::resource('dossier','Api\DossierMedicalController')->except(['create','edit']);
    Route::resource('gestionnaire','Api\GestionnaireController')->except(['create','edit']);

//        Route pour ajouter ou supprimer les etablissement d'un praticien
    Route::post('praticien/add-etablissement','Api\PraticienController@addEtablissement');
    Route::post('praticien/delete-etablissement','Api\PraticienController@removeEtablissement');
    Route::post('medecin-controle/add-etablissement','Api\MedecinControleController@addEtablissement');
    Route::post('medecin-controle/delete-etablissement','Api\MedecinControleController@removeEtablissement');

    //        Route pour ajouter ou supprimer les etablissement d'un praticien
    Route::post('etablissement/delete-patient','Api\EtablissementPatientController@retirerPatientAEtablissement');

    Route::post('etablissement/{etablissement}','Api\EtablissementExerciceController@update')->name('etablissement.info.update');

    Route::post('medecin-controle/{medecin}','Api\MedecinControleController@update')->name('medecin.controle.update');
    Route::post('praticien/{praticien}','Api\PraticienController@update')->name('praticien.post.update');

});

//    Définition des routes accéssible par le praticien
Route::group(['middleware' => ['auth:api','role:Admin|Praticien|Medecin controle']], function () {
    Route::put('resultat-labo/{id}/transmettre','Api\ResultatLaboController@transmit');
    Route::put('resultat-imagerie/{id}/transmettre','Api\ResultatImagerieController@transmit');
    Route::put('consultation-medecine/{id}/transmettre','Api\ConsultationMedecineGeneraleController@transmettre');
    Route::put('consultation-medecine/{id}/reactiver','Api\ConsultationMedecineGeneraleController@reactiver');
    Route::post('consultation-medecine/{slug}','Api\ConsultationMedecineGeneraleController@update');
    Route::put('consultation-obstetrique/{id}/transmettre','Api\ConsultationObstetriqueController@transmettre');
    Route::put('consultation-prenatale/{id}/transmettre','Api\ConsultationPrenantaleController@transmettre');
    Route::put('hospitalisation/{hospitalisation}/transmettre','Api\HospitalisationController@transmettre');


});


//    Définition des routes accéssible par le medecin controle
Route::group(['middleware' => ['auth:api','role:Admin|Medecin controle']], function () {
    Route::put('resultat-labo/{resultat}/archiver','Api\ResultatLaboController@archive');
    Route::put('hospitalisation/{hospitalisation}/archiver','Api\HospitalisationController@archiver');
    Route::put('resultat-imagerie/{resultat}/archiver','Api\ResultatImagerieController@archive');
    Route::put('consultation-medecine/{consultation_medecine}/archiver','Api\ConsultationMedecineGeneraleController@archiver');
    Route::put('consultation-obstetrique/{consultation_obstetrique}/archiver','Api\ConsultationObstetriqueController@archiver');
    Route::put('consultation-prenatale/{consultation_prenatale}/archiver','Api\ConsultationPrenantaleController@archiver');
});

//    Définition des routes accéssible par le patient
Route::group(['middleware' => ['auth:api','role:Admin|Patient']], function () {
    Route::resource('consultation-obstetrique','Api\ConsultationObstetriqueController')->only('show','index');
    Route::get('{patient}/dossier-medical','Api\DossierMedicalController@dossierByPatientId');

});

//  Définition des routes accéssible a la fois par le patient, le medecin controle et le souscripteur
Route::group(['middleware' => ['auth:api','role:Admin|Patient|Medecin controle|Souscripteur']], function () {


});

//  Définition des routes accéssible a la fois par le medecin controle et le praticien
Route::group(['middleware' => ['auth:api','role:Admin|Medecin controle|Praticien']], function () {
    Route::resource('etablissement','Api\EtablissementExerciceController')->except(['create','store','destroy','edit']);
    Route::resource('consultation-medecine','Api\ConsultationMedecineGeneraleController')->except(['create','edit']);
    Route::resource('consultation-obstetrique','Api\ConsultationObstetriqueController')->except(['create','edit']);
    Route::resource('motif','Api\MotifController')->except(['create','edit']);
    Route::resource('allergie','Api\AllergieController')->except(['create','edit']);
    Route::resource('antecedent','Api\AntecedentController')->except(['create','edit']);
    //Route::resource('traitement','Api\TraitementController')->except(['create','edit']);
    Route::resource('traitement-actuel','Api\TraitementActuelController')->except(['create','edit']);
    Route::resource('traitement-propose','Api\TraitementProposeController')->except(['create','edit']);
    Route::resource('parametre-commun','Api\ParametreCommunController')->except(['create','edit']);
    Route::resource('conclusion','Api\ConclusionController')->except(['create','edit']);
    Route::resource('resultat-labo','Api\ResultatLaboController')->except(['create','edit','update']);
    Route::resource('resultat-imagerie','Api\ResultatImagerieController')->except(['create','edit','update']);
    Route::post('resultat-labo/{resultat}','Api\ResultatLaboController@update')->name('resultat.labo.update');
    Route::post('resultat-imagerie/{resultat}','Api\ResultatImagerieController@update')->name('resultat.imagerie.update');
    Route::resource('consultation-prenatale','Api\ConsultationPrenantaleController')->except(['create','edit']);
    Route::resource('parametre-obstetrique','Api\ParametreObstetriqueController')->except(['create','edit']);
    Route::resource('echographie','Api\EchographieController')->except(['create','edit']);
    Route::resource('hospitalisation','Api\HospitalisationController')->except(['create','edit']);

    Route::post('consultation-medecine-motif/retirer-motif','Api\ConsultationMotifController@removeMotif');
    Route::post('consultation-medecine-motif/ajouter-motif','Api\ConsultationMotifController@ajouterMotif');

    Route::post('hospitalisation/ajouter-motif','Api\HospitalisationMotifController@ajouterMotif');
    Route::post('hospitalisation/retirer-motif','Api\HospitalisationMotifController@removeMotif');

    Route::post('retirer-allergie','Api\DossierAllergieController@retirerAllergie');
    Route::post('ajouter-allergie','Api\DossierAllergieController@ajouterAllergie');
    Route::post('ajouter-allergie-version','Api\DossierAllergieController@ajouterAllergieVersionDeux');

    Route::post('retirer-traitement','Api\ConsultationTraitementController@retirerTraitement');
    Route::post('ajouter-traitement','Api\ConsultationTraitementController@ajouterTraitement');

    Route::get('max-consultation-obs','Api\ConsultationObstetriqueController@genererNumeroGrossesse');

    Route::get('latest-operation','Api\AuteurController@latestOperation');
});
//  Définition des routes accéssible a la fois par le patient, le medecin controle, le souscripteur et le praticien
Route::group(['middleware' => ['auth:api','role:Admin|Patient|Medecin controle|Souscripteur|Praticien']], function () {
    Route::resource('consultation-medecine','Api\ConsultationMedecineGeneraleController')->except('store','update','destroy');
    Route::resource('consultation-obstetrique','Api\ConsultationObstetriqueController')->except('store','update','destroy');
    Route::resource('motif','Api\MotifController')->except('store','update','destroy');
    Route::resource('allergie','Api\AllergieController')->except('store','update','destroy');
    Route::resource('antecedent','Api\AntecedentController')->except('store','update','destroy');
    Route::resource('traitement-actuel','Api\TraitementActuelController')->except('store','update','destroy');
    Route::resource('traitement-propose','Api\TraitementProposeController')->except('store','update','destroy');
    Route::resource('parametre-commun','Api\ParametreCommunController')->except('store','update','destroy');
    Route::resource('conclusion','Api\ConclusionController')->except('store','update','destroy');
    Route::resource('resultat-labo','Api\ResultatLaboController')->except('store','update','destroy');
    Route::resource('resultat-imagerie','Api\ResultatImagerieController')->except('store','update','destroy');
    Route::resource('consultation-prenatale','Api\ConsultationPrenantaleController')->except('store','update','destroy');
    Route::resource('parametre-obstetrique','Api\ParametreObstetriqueController')->except('store','update','destroy');
    Route::resource('echographie','Api\EchographieController')->except('store','update','destroy');
    Route::resource('hospitalisation','Api\HospitalisationController')->except('store','update','destroy');
});

Route::group(['middleware' => ['auth:api','role:Admin|Gestionnaire|Patient|Medecin controle|Souscripteur|Praticien']], function () {
    Route::resource('dossier','Api\DossierMedicalController')->except('store','update','destroy');
    Route::get('imprimer-dossier/{dossier}','Api\ImprimerController@dossier');
    Route::get('imprimer-consultation-medecine/{generale}','Api\ImprimerController@generale');
});

Route::group(['middleware' => ['auth:api','role:Admin|Gestionnaire|Praticien']], function () {
    Route::resource('souscripteur','Api\SouscripteurController');

});

Route::group(['middleware' => ['auth:api','role:Admin|Gestionnaire|Praticien|Patient|Medecin controle|Souscripteur']], function () {
    Route::get('affiliationRevue/{affiliation}','Api\AffiliationController@show');
    Route::get('patient/{patient}','Api\PatientController@show')->name('patient.show');

});


Route::group(['middleware' => ['auth:api','role:Admin|Gestionnaire|Praticien|Medecin controle|Souscripteur|Patient']], function () {
    Route::get('patient','Api\PatientController@index')->name('patient.index');
    Route::get('souscripteur/{souscripteur}','Api\SouscripteurController@show')->name('souscripteur.show');
});


Route::group(['middleware' => ['auth:api','role:Admin|Medecin controle|Praticien|Gestionnaire|Patient|Souscripteur']], function () {
    Route::resource('etablissement', 'Api\EtablissementExerciceController')->except(['create', 'store', 'destroy', 'edit']);
    Route::get('user-etablissements', 'Api\EtablissementExerciceController@userEtablissements');
});
Route::group(['middleware' => ['auth:api','role:Admin|Gestionnaire|Praticien']], function () {
    Route::post('patient','Api\PatientController@store')->name('patient.store');
    Route::put('patient/{patient}','Api\PatientController@update')->name('patient.update');
    Route::delete('patient/{patient}','Api\PatientController@destroy')->name('patient.destroy');
    Route::post('patient/add-etablissement','Api\EtablissementPatientController@ajouterPatientAEtablissement');

});
