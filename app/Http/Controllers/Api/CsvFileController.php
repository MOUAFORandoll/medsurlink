<?php

namespace App\Http\Controllers\Api;

use App\Imports\PrestationImport;
use App\Models\EtablissementExercice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Excel;

class CsvFileController extends Controller
{
    public function csv_import(){

        $prestations = new PrestationImport(\request()->get('etablissement_id'));

        \Maatwebsite\Excel\Facades\Excel::import( $prestations,\request()->file('file'));

        $etablissement = EtablissementExercice::with('prestations')->whereId($prestations->getEtablissementId())->first();

        return response()->json(['etablissementPrestation'=>$etablissement]);
    }
}
