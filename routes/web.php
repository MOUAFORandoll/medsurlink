<?php
use App\Models\ContratIntermediationMedicale;
use Barryvdh\DomPDF\Facade as PDF;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/public/storage/DossierMedicale/{fileNumber}/Consultation/{consultation}/{image}', function ($fileNumber,$consultation,$image) {
    $path = public_path().'/storage/DossierMedicale/'.$fileNumber.'/Consultation/'.$consultation.'/'.$image;
    return response()->file($path);
});

Route::get('/public/storage/DossierMedicale/{fileNumber}/ConsultationGenerale/{image}', function ($fileNumber,$image) {
    $path = public_path().'/storage/DossierMedicale/'.$fileNumber.'/ConsultationGenerale/'.$image;
    return response()->file($path);
});

Route::get('/public/storage/DossierMedicale/{fileNumber}/Cardiologie/{identifiant}/{resource}', function ($fileNumber,$identifiant,$resource) {
    $path = public_path().'/storage/DossierMedicale/'.$fileNumber.'/Cardiologie/'.$identifiant.'/'.$resource;
    return response()->file($path);
});

Route::get('/public/storage/Medecin/{fileNumber}/Signature/{image}', function ($fileNumber,$image) {
    $path = public_path().'/storage/Medecin/'.$fileNumber.'/Signature/'.'/'.$image;
    return response()->file($path);
});

Route::get('/public/storage/Praticien/{fileNumber}/Signature/{image}', function ($fileNumber,$image) {
    $path = public_path().'/storage/Praticien/'.$fileNumber.'/Signature/'.'/'.$image;
    return response()->file($path);
});

Route::get('/public/storage/Etablissement/{fileNumber}/Logo/{image}', function ($fileNumber,$image) {
    $path = public_path().'/storage/Etablissement/'.$fileNumber.'/Logo'.'/'.$image;
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

Route::get('{all}', function () {
    return view('dashboard');
//})->where('all', '^(dashboard).*$');
})//->middleware('auth','isAdmin')
->where('all', '^admin|admin/|admin/.*,dashboard|dashboard/|dashboard/.*$');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
