<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\ExamenComplementaire;

class ExamenComplementaireController extends Controller
{
    public function index()
    {
        $examencomplementaire = ExamenComplementaire::get();
        return response()->json(['examencomplementaire'=>$examencomplementaire]);
    }
}
