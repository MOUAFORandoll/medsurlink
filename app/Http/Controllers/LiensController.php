<?php

namespace App\Http\Controllers;

use App\Models\Dictionnaire;
use Illuminate\Http\JsonResponse;

class LiensController extends Controller
{
    public function index(): JsonResponse
    {
        $liens = Dictionnaire::where("reference", "lien_parente")->get();

        return response()->json([
            'liens' => $liens
        ]);
    }
}