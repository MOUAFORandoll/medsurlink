<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PraticienRequest extends FormRequest
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
            "specialite_id"=>'required|integer|exists:specialites,id',
            "profession_id"=>'required|integer|exists:professions,id',
            "etablissement_id"=>'required|integer|exists:etabissement_exercices,id',
            "nom"=>'required|string|min:2',
            "civilite"=>["required",Rule::in(['M.','Mme/Mlle.','Dr.','Pr'])],
            "nationalite"=>'required|string|min:4',
            "ville"=>'required|string|min:2',
            "pays"=>'required|string|min:2',
            "telephone"=>'required|string|min:9',
            "email"=>'required|string|unique:patients',
            "quartier"=>'sometimes|nullable|string|min:1',
            "prenom"=>'sometimes|nullable|string|min:2',
            "code_postal"=>'sometimes|integer',
            "date_de_naissance"=>'required|date',
        ];
    }
}
