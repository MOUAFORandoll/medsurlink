<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrdonanceRequest extends FormRequest
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
            'dossier_medical_id'=>'required|exists:dossier_medicals,id',
            'date_prescription'=>'requierd|date',
            'medicaments.*.*'=>'required|integer|exists:medicaments,id'
        ];
    }
}
