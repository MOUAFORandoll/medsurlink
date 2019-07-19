<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DossierMedicalRequest extends FormRequest
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
            "patient_id"=>"required|integer|exists:patients,id",
            "date_de_creation"=>"sometimes|nullable|date",
            "numero_dossier"=>"sometimes|string|min:8|unique:dossier_medicals,numero_dossier",
        ];
    }
}
