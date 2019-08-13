<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EchographieRequest extends FormRequest
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
            "type"=>"required|string",
            "ddr"=>"required|date",
            "dpa"=>"required|date",
            "semaine_amenorrhee"=>"required|integer",
            "date_creation"=>"sometimes|nullable|date",
            "biometrie"=>"sometimes|nullable|string",
            "annexe"=>"sometimes|nullable|string",
            "description"=>"sometimes|nullable|string",
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        return response()->json(['error'=>$validator->errors()],419);
    }
}
