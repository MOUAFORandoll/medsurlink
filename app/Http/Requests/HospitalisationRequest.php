<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class HospitalisationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [
            "dossier_medical_id"=>"required|integer|exists:dossier_medicals,id",
            "histoire_clinique"=>"required|string",
            "date_entree"=>"sometimes|nullable|date|before_or_equal:date_sortie",
            "date_sortie"=>"sometimes|nullable|date|after_or_equal:date_entree",
            "mode_de_vie"=>"sometimes|nullable|string",
            "evolution"=>"sometimes|nullable|string",
            "conclusion"=>"sometimes|nullable|string",
            "avis"=>"sometimes|nullable|string",
            "traitement_sortie"=>"sometimes|nullable|string",
            "rendez_vous"=>"sometimes|nullable|date|after_or_equal:date_sortie",
            "examen_clinique"=>"sometimes|nullable|string|min:2",
            "examen_complementaire"=>"sometimes|nullable|string|min:2",
            'etablissement_id'=>'required|integer|exists:etablissement_exercices,id',
            'motifs.*'=>'required'
        ];

        return $rules;
    }
}
