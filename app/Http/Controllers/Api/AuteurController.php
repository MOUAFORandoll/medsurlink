<?php

namespace App\Http\Controllers\Api;

use App\Models\Auteur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuteurController extends Controller
{

    public static function store($auteurable_type,$auteurable_id,$operationable_type,$operationable_id,$action,$patient_id){

        Auteur::create([
            'user_id'=>Auth::id(),
            "auteurable_type"=>$auteurable_type,
            "auteurable_id"=>$auteurable_id,
            "operationable_type"=>$operationable_type,
            "operationable_id"=>$operationable_id,
            "action"=>$action,
            "patient_id"=>$patient_id
        ]);
    }

    public function latestOperation(){
        $lastOperations = Auteur::with('user')
            ->where('user_id','=',Auth::id())
            ->where('action','not like','connexion')
            ->whereNotNull('operationable_id')
            ->whereNotNull('patient_id')
            ->distinct('operationable_id')
            ->limit(20)
            ->orderByDesc('created_at')
            ->get();
        foreach ($lastOperations as $operation){
            $operation['dossier']=$operation->user->patient->dossier;
        }

        return response()->json(compact('lastOperations'));
    }
}
