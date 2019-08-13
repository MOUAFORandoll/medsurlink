<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            "consultation_medecine_generale_id"=>"required|integer|exists:consultation_medecine_generales,id",
            "poids"=>"sometimes|nullable|numeric",
            "taille"=>"sometimes|nullable|numeric",
            "bmi"=>"sometimes|nullable|numeric",
            "ta_systolique"=>"sometimes|nullable|numeric",
            "ta_diastolique"=>"sometimes|nullable|numeric",
            "temperature"=>"sometimes|nullable|numeric",
            "frequence_cardiaque"=>"sometimes|nullable|numeric",
            "sato2"=>"sometimes|nullable|numeric"
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        return response()->json(['error'=>$validator->errors()],419);
    }
}
