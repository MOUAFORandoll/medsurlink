<?php
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\ContratIntermediationMedicale;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/contrat/{id}', function ($id) {

    $cim= ContratIntermediationMedicale::find($id);
    return view('contrat',compact('cim'));
});

Route::get('imprimer/contrat/{id}', function ($id) {
    $cim = ContratIntermediationMedicale::find($id);
    $data = ['cim'=>$cim];
    $pdf = PDF::loadView('contrat_version_imprimable',$data);
    return $pdf->download("Contrat d'intermediation medicale - ".strtoupper($cim->nomPatient)." ".ucfirst($cim->prenomPatient)." - ".ucfirst($cim->typeSouscription).".pdf");
});
