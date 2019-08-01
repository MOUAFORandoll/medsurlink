<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            "dossier_medical_id"=>"required|integer|exists:dossier_medicals,id",
            "histoire_clinique"=>"required|string",
            "date_entree"=>"sometimes|nullable|date",
            "date_sortie"=>"sometimes|nullable|date",
            "mode_de_vie"=>"sometimes|nullable|string",
            "evolution"=>"sometimes|nullable|string",
            "conclusion"=>"sometimes|nullable|string",
            "avis"=>"sometimes|nullable|string",
            "traitement_sortie"=>"sometimes|nullable|string",
            "rendez_vous"=>"sometimes|nullable|string",
        ];
    }
}
