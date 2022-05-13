<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;

use App\Models\OtherComplementaire;
use App\Http\Controllers\Controller;
use App\Models\ExamenComplementaire;

class ExamenComplementaireController extends Controller
{
    public function index()
    {    
        // $othercomplementaire = OtherComplementaire::get()->toArray();
        $examencomplementaire = ExamenComplementaire::get()->toArray();
        // $fusion = array_merge($examencomplementaire);
        return response()->json([
            'examencomplementaire'=>$examencomplementaire
        ]);
    }
}
