<?php

use App\Models\AffiliationSouscripteur;
use App\Models\CommandePackage;
use App\Models\ContratIntermediationMedicale;
use App\Models\CompteRenduOperatoire;
use App\Models\PaymentOffre;
use Barryvdh\DomPDF\Facade as PDF;
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
    $ville = $affiliation->souscripteur->user->ville;
    $beneficiaire ="FOUKOUOP NDAM Rebecca";

    $pdf = generationPdfFactureOffre($commande_id, $commande_date, $montant_total, $echeance, $description, $quantite, $prix_unitaire, $nom_souscripteur, $email_souscripteur, $rue, $adresse, $ville, $beneficiaire);
    return $pdf['stream'];
})->name('facture.offre');
/*
Route::get('{all}', function () {
    return view('dashboard');
//})->where('all', '^(dashboard).*$');
})//->middleware('auth','isAdmin')
->where('all', '^admin|admin/|admin/.*,dashboard|dashboard/|dashboard/.*$');
*/

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

