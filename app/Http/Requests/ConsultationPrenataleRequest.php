<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class ConsultationPrenataleRequest extends FormRequest
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
            "consultation_obstetrique_id"=>"required|integer|exists:consultation_obstetriques,id",
            "type_de_consultation"=>"required|string|min:2",
            "date_creation"=>"sometimes|nullable|date",
            "plaintes"=>"sometimes|nullable|string|min:2",
            "recommandations"=>"sometimes|nullable|string|min:2",
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        Request::merge(['error'=>$validator->errors()->getMessages()]);

    }
}
