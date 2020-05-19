<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardiologieRequest extends FormRequest
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
        $rules = [
            "etablissement_id"=>'required|integer|exists:etablissement_exercices,id',
            "dossier_medical_id"=>"required|integer|exists:dossier_medicals,id",
            "date_consultation"=>"sometimes|nullable|date",
            "anamnese"=>"sometimes|nullable|string",
            "examen_clinique"=>"sometimes|nullable|string",
            "facteur_de_risque"=>"sometimes|nullable|string",
            "profession"=>"sometimes|nullable|string",
            "situation_familiale"=>"sometimes|nullable|string",
            "nbre_enfant"=>"sometimes|nullable|string",
            "tabac"=>"sometimes|nullable|string",
            "alcool"=>"sometimes|nullable|string",
            "autres"=>"sometimes|nullable|string",
            "conclusion"=>"sometimes|nullable|string",
            "perimetre_abdominal"=>"sometimes|nullable|string",
            "conduite_a_tenir"=>"sometimes|nullable|string",
            "rendez_vous"=>"sometimes|nullable|string",
            "nbreCigarette"=>"sometimes|nullable|string",
            "nbreAnnee"=>"sometimes|nullable|string",
            "contributeurs.*" => "sometimes|nullable|integer",
            "examen_cardio"=>"sometimes|nullable",
            "examen_cardio.*.nom"=>"required|string",
            "examen_cardio.*.date_examen"=>"required|date",
            "examen_cardio.*.description"=>"required|string",
            "motifRdv"=>"sometimes|nullable|string"
        ];

        $rules["traitements"]="sometimes|nullable|string";


        return $rules;
    }
}
