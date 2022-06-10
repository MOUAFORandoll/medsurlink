<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\OtherComplementaire;
use App\Http\Controllers\Controller;

class OtherComplementaireController extends Controller
{
    public function index()
    {
        $othercomplementaire = OtherComplementaire::get();
        return response()->json(['othercomplementaire'=>$othercomplementaire]);
    }
}
