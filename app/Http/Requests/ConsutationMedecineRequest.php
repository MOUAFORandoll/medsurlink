<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsutationMedecineRequest extends FormRequest
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
            "dossier_medical_id"=>"required|integer|exists:dossier_medicals,id",
            "date_consultation"=>"sometimes|nullable|date",
            "anamese"=>"sometimes|nullable|string|min:5",
            "mode_de_vie"=>"sometimes|nullable|string|min:5",
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        return response()->json(['error'=>$validator->errors()],419);
    }
}
