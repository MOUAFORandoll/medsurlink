<?php

namespace App\Http\Controllers\Api;

use App\Models\ConsultationMedecineGenerale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConsultationMotifController extends Controller
{
    public function removeMotif(Request $request){
        $request->validate([
            "consultation"=>"required|integer|exists:consultation_medecine_generales,id",
            "motif"=>"required|integer|exists:motifs,id"
        ]);

        $consultation = ConsultationMedecineGenerale::find($request->get('consultation'));
        $consultation->motifs()->detach($request->get('motif'));

        $consultation = ConsultationMedecineGenerale::with('motifs')->find($request->get('consultation'));
        return response()->json(['consultation'=>$consultation]);
    }
}
