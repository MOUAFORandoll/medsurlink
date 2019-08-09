<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SouscripteurStoreRequest extends FormRequest
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
            "user_id"=>'sometimes|integer|exists:users,id',
            "sexe"=>["required",Rule::in(['M','F'])],
            "date_de_naissance"=>'required|date',
//            "nationalite"=>'required|string|min:4',
//            "ville"=>'required|string|min:2',
//            "pays"=>'required|string|min:2',
//            "telephone"=>'required|string|min:9',
//            "email"=>'required|string|unique:users,email',
//            "quartier"=>'sometimes|nullable|string|min:1',
//            "code_postal"=>'sometimes|integer',
//            "prenom"=>'sometimes|nullable|string|min:2',
//            "nom"=>'required|string|min:2',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        return response()->json(['error'=>$validator->errors()],419);
    }
}
