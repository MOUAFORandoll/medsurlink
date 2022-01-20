<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FactureAvisRequest extends FormRequest
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
            'etablissement_id'=>'required|integer|exists:etablissement_exercices,id',
            'dossier_medical_id' => "required|integer|exists:dossier_medicals,id",
            'avis_id' => "required",
            'association_id' => "required|integer|exists:associations,id"
        ];
    }
}
