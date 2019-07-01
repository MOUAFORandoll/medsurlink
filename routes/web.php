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

/**-- Headers --**/
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE, PATCH');
header('Access-Control-Allow-Headers:  Origin, Content-Type, X-Auth-Token, Authorization, X-Requested-With, x-xsrf-token');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/contrat/{id}', function ($id) {

    $cim= ContratIntermediationMedicale::find($id);
    return view('contrat',compact('cim'));
});

Route::get('imprimer/contrat/{id}', function ($id) {
    $data = ['cim'=>ContratIntermediationMedicale::find($id)];
    $pdf = PDF::loadView('contrat_version_imprimable',$data);
    return $pdf->download('invoice.pdf');
});

Route::get('{all}', function () {
    return view('dashboard');
//})->where('all', '^(dashboard).*$');
})//->middleware('auth','isAdmin')
    ->where('all', '^admin|admin/|admin/.*,dashboard|dashboard/|dashboard/.*$');
