<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class ParametreCommunRequest extends FormRequest
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
            "consultation_medecine_generale_id"=>"sometimes|nullable|integer|exists:consultation_medecine_generales,id",
            "poids"=>"sometimes|nullable|numeric",
            "taille"=>"sometimes|nullable|numeric",
            "bmi"=>"sometimes|nullable|numeric",
            "ta_systolique"=>"sometimes|nullable|numeric",
            "ta_systolique_d"=>"sometimes|nullable|numeric",
            "ta_diastolique"=>"sometimes|nullable|numeric",
            "ta_diastolique_d"=>"sometimes|nullable|numeric",
            "temperature"=>"sometimes|nullable|numeric",
            "frequence_cardiaque"=>"sometimes|nullable|numeric",
            "frequence_respiratoire"=>"sometimes|nullable|numeric",
            "perimetre_abdominal"=>"sometimes|nullable|numeric",
            "sato2"=>"sometimes|nullable|numeric",
            'communable_type'=>"sometimes|nullable|string",
            'communable_id'=>"sometimes|nullable|integer",
        ];
    }

}
