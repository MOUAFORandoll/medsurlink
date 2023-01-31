<?php


/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
| Here is where you can register user routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "user" middleware group. Now create something great!
|
*/

Route::post('v2/oauth/token', 'Api\AuthController@auth');

/**
 * Signature
 */
Route::post('v2/signature/user', 'Api\UserController@signature')->middleware('auth:api');

Route::prefix('v2')->namespace('Api\v2\Teleconsultation')->middleware(['client.credentials'])->group(function () {


    /**
     * CRUDS allergies
     */
    Route::group(['prefix' => 'allergies'], function () {
        Route::get('/', 'AllergieController@index');
        Route::post('/', 'AllergieController@store');
        Route::get('/{allergie}', 'AllergieController@show');
        Route::patch('/{allergie}', 'AllergieController@update');
        Route::delete('/{relation_id}/{allergie}/{relation}', 'AllergieController@destroy');
    });

    /**
     * CRUDS types
     */

    Route::group(['prefix' => 'types'], function () {
        Route::get('/', 'TypeController@index');
        Route::get('/{type}', 'TypeController@show');
    });

    /**
     * CRUDS teleconsultations
     */
    Route::group(['prefix' => 'teleconsultations'], function () {
        Route::get('/', 'TeleconsultationController@index');
        Route::post('/', 'TeleconsultationController@store');

        Route::get('/create/{medecin_id}/{patient_id}', 'TeleconsultationController@alerte');
        Route::get('/allergies/{patient_id}', 'TeleconsultationController@fetchAllergies');
        Route::get('/antecedents/{patient_id}', 'TeleconsultationController@fetchAntecedents');
        Route::get('/print/{teleconsultation_id}', 'TeleconsultationController@printTeleconsultation');


        Route::get('/{teleconsultation}', 'TeleconsultationController@show');
        Route::patch('/{teleconsultation}', 'TeleconsultationController@update');
        Route::delete('/{teleconsultation}', 'TeleconsultationController@destroy');
    });

    /**
     * CRUD TELECONSULTATIONS
     */
    Route::group(['prefix' => 'mettings'], function () {
        Route::get('/create/{user_id}', 'BigBlueButtonController@createMetting');
        Route::get('/join/{user_id}', 'BigBlueButtonController@joinMetting');
     });

     /**
     * CRUDS anamneses
     */
    Route::group(['prefix' => 'anamneses'], function () {
        Route::get('/', 'AnamneseController@index');
        Route::post('/', 'AnamneseController@store');
        Route::get('/{anamnese}', 'AnamneseController@show');
        Route::patch('/{anamnese}', 'AnamneseController@update');
        Route::delete('/{anamnese}', 'AnamneseController@destroy');
    });

    /**
     * CRUDS antecedents
     */
    Route::group(['prefix' => 'antecedents'], function () {
        Route::get('/', 'AntecedentController@index');
        Route::post('/', 'AntecedentController@store');
        Route::get('/{antecedent}', 'AntecedentController@show');
        Route::patch('/{antecedent}', 'AntecedentController@update');
        Route::delete('/{antecedent}', 'AntecedentController@destroy');
    });

    /**
     * CRUDS etablissements
     */
    Route::group(['prefix' => 'etablissements'], function () {
        Route::get('/', 'EtablissementController@index');
        Route::post('/', 'EtablissementController@store');
        Route::get('/{etablissement}', 'EtablissementController@show');
        Route::patch('/{etablissement}', 'EtablissementController@update');
        Route::delete('/{etablissement}', 'EtablissementController@destroy');
    });


    /**
     * CRUDS examen_cliniques
     */
    Route::group(['prefix' => 'examen_cliniques'], function () {
        Route::get('/', 'ExamenCliniqueController@index');
        Route::post('/', 'ExamenCliniqueController@store');
        Route::get('/{examen_clinique}', 'ExamenCliniqueController@show');
        Route::patch('/{examen_clinique}', 'ExamenCliniqueController@update');
        Route::delete('/{relation_id}/{examen_clinique}/{relation}', 'ExamenCliniqueController@destroy');
    });

    /**
     * CRUDS examen_complementaires
     */
    Route::group(['prefix' => 'examen_complementaires'], function () {
        Route::get('/', 'ExamenComplementaireController@index');
        Route::post('/', 'ExamenComplementaireController@store');
        Route::get('/{examen_complementaire}', 'ExamenComplementaireController@show');
        Route::patch('/{examen_complementaire}', 'ExamenComplementaireController@update');
        Route::delete('/{relation_id}/{examen_complementaire}/{relation}', 'ExamenComplementaireController@destroy');
    });

    /**
     * CRUDS motifs
     */
    Route::group(['prefix' => 'motifs'], function () {
        Route::get('/', 'MotifController@index');
        Route::post('/', 'MotifController@store');
        Route::get('/{motif}', 'MotifController@show');
        Route::patch('/{motif}', 'MotifController@update');
        Route::delete('/{relation_id}/{motif}/{relation}', 'MotifController@destroy');
    });

    /**
     * CRUDS niveau urgences
     */
    Route::group(['prefix' => 'niveau_urgences'], function () {
        Route::get('/', 'NiveauUrgenceController@index');
        Route::post('/', 'NiveauUrgenceController@store');
        Route::get('/{niveau_urgence}', 'NiveauUrgenceController@show');
        Route::patch('/{niveau_urgence}', 'NiveauUrgenceController@update');
        Route::delete('/{niveau_urgence}', 'NiveauUrgenceController@destroy');
    });

    /**
     * CRUDS niveau urgences
     */
    Route::group(['prefix' => 'statuts'], function () {
        Route::get('/', 'StatutController@index');
        Route::post('/', 'StatutController@store');
        Route::get('/{statut}', 'StatutController@show');
        Route::patch('/{statut}', 'StatutController@update');
        Route::delete('/{statut}', 'StatutController@destroy');
    });

    /**
    * CRUDS rendez-vous
    */
    Route::group(['prefix' => 'rendez_vous'], function () {
        Route::get('/', 'RendezVousController@index');
        Route::post('/', 'RendezVousController@store');
        Route::get('/{rendez_vous}', 'RendezVousController@show');
        Route::patch('/{rendez_vous}', 'RendezVousController@update');
        Route::delete('/{rendez_vous}', 'RendezVousController@destroy');
    });

    /**
    * CRUDS patients
    */
    Route::group(['prefix' => 'patients'], function () {
        Route::get('/', 'PatientController@index');
       /*  Route::post('/', 'PatientController@store'); */
        Route::get('/{patient_id}', 'PatientController@show');
        /* Route::patch('/{rendez_vous}', 'PatientController@update');
        Route::delete('/{rendez_vous}', 'PatientController@destroy'); */
    });

     /**
    * CRUDS medecins
    */
    Route::group(['prefix' => 'medecins'], function () {
        Route::get('/', 'PatientController@getAllMedecinControles');
    });

    /**
     * Informations des utilisateurs connectés
     */
    Route::group(['prefix' => 'user'], function () {
        Route::get('/medecin', 'UserController@medecin');
    });

    Route::resource('alertes', 'AlerteController');
    Route::patch('/alertes/{alerte}/assignMedecin', 'AlerteController@assignMedecin');

    /**
    * CRUDS notifications
    */
    Route::group(['prefix' => 'notifications'], function () {
        Route::get('/', 'NotificationController@index');
        Route::get('/read_all', 'NotificationController@readAll');
        Route::get('/{notification}', 'NotificationController@markAsRead');
        Route::post('/', 'NotificationController@store');
        /* Route::post('/', 'NotificationController@store');
        Route::patch('/{rendez_vous}', 'NotificationController@update');
        Route::delete('/{rendez_vous}', 'NotificationController@destroy'); */
    });

    /**
    * CRUDS diagnostics
    */
    Route::group(['prefix' => 'diagnostics'], function () {
        Route::get('/', 'DiagnosticController@index');
        Route::post('/', 'DiagnosticController@store');
        Route::get('/{diagnostic}', 'DiagnosticController@show');
        Route::patch('/{diagnostic}', 'DiagnosticController@update');
        Route::delete('/{diagnostic}', 'DiagnosticController@destroy');
    });

    /**
    * CRUDS Ordonnance
    */
    Route::group(['prefix' => 'ordonnances'], function () {
        Route::get('/', 'OrdonnanceController@index');
        Route::post('/', 'OrdonnanceController@store');
        Route::get('/{ordonnance}', 'OrdonnanceController@show');
        Route::patch('/{ordonnance}', 'OrdonnanceController@update');
        Route::delete('/{relation_id}/{ordonnance}/{relation}', 'OrdonnanceController@destroy');
    });


});