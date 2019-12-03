<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class ParametreObstRequest extends FormRequest
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
            "consultation_prenatale_id"=>"required|exists:consultation_prenatales,id",
            "poids"=>"sometimes|nullable|integer",
            "ta_systolique"=>"sometimes|nullable|numeric",
            "ta_diastolique"=>"sometimes|nullable|numeric",
            "hauteur_urine"=>"sometimes|nullable|numeric",
            "toucher_vaginal"=>"sometimes|nullable|numeric",
            "bruit_du_coeur"=>"sometimes|nullable|numeric",
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        Request::merge(['error'=>$validator->errors()->getMessages()]);
    }
}
