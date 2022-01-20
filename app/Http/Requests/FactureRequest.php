<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FactureRequest extends FormRequest
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
            'etablissement_id'=>'required|integer|exists:etablissement_exercices,id',
            'dossier_medical_id'=>"required|integer|exists:dossier_medicals,id",
            'total_hors_remise'=>"required|string",
            'total_avec_remise'=>"sometimes|nullable|string",
            'date_facturation'=>"required|date",
            'statut'=>"sometimes|string",
            'remise'=>"sometimes|nullable|string",
            'motif'=>"sometimes|nullable|string",
        ];

        if ($this->method() == 'POST'){
            $rules['prestation.*.date_prestation'] = "required|date";
            $rules['prestation.*.prestation_id'] = "required|integer|exists:etablissement_prestation,id";

        }

        return  $rules;
    }
}
