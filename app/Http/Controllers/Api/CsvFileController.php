<?php

namespace App\Http\Controllers\Api;

use App\Imports\PrestationImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Excel;

class CsvFileController extends Controller
{
    public function csv_import(){
        $prestations = new PrestationImport;
        \Maatwebsite\Excel\Facades\Excel::import( $prestations,\request()->file('file'));
    }
}
