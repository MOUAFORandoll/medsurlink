<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsultationFichierRequest extends FormRequest
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
            "name"=>'sometimes|nullable|string',
            "dossier_medical_id"=>"required|string|exists:dossier_medicals,slug",
            "etablissement_id"=>'required|integer|exists:etablissement_exercices,id',
            "user_id"=>"sometimes|nullable",
            "date_consultation"=>"required|date",
            "praticien_externe"=>'sometimes|nullable|string',
            "consultation_externe"=>'sometimes|nullable|string'
        ];
    }
}
