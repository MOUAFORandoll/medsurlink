<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActiviteRequest extends FormRequest
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
//            'dossier_medical_id'=>"sometimes|integer|exists:dossier_medicals,id",
//            'nom_activite'=>"sometimes|nullable|string",
//            'groupe_activite'=>"sometimes|nullable|string",
//            'nom_partenaire'=>"sometimes|nullable|string",
//            'description'=>"sometimes|nullable|string",
//            'statut'=>"sometimes|nullable|string",
//            'commentaires'=>"sometimes|nullable|string",
//            'date'=>"sometimes|nullable|string",
        ];
    }
}
