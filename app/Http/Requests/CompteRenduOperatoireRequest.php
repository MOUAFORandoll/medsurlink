<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompteRenduOperatoireRequest extends FormRequest
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
            "etablissement_id"=>'required|integer|exists:etablissement_exercices,id',
            "dossier_medical_id"=>"required|integer|exists:dossier_medicals,id",
            'type_intervention'=>'required|string',
            'histoire_clinique'=>'required|string',
            'date_intervention'=>'required|string',
            'chirugiens'=>'required|string',
            'aides'=>'required|string',
            'circulants'=>'required|string',
            'anesthesistes'=>'required|string',
            'type_anesthesie'=>'required|string',
            'description'=>'required|string',
            'traitement_post_operatoire'=>'required|string',
        ];
    }
}
