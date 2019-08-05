<?php

namespace App\Http\Requests;

use App\Rules\EmailExistRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PatientUpdateRequest extends FormRequest
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
        $id = $this->route()->parameter('patient');

        return [
            "user_id"=>'sometimes|integer|exists:users,id',
            "nom"=>'required|string|min:2',
            "souscripteur_id"=>'required|integer|exists:souscripteurs,id',
            "sexe"=>["required",Rule::in(['M','F'])],
            "date_de_naissance"=>'required|date',
            "nationalite"=>'required|string|min:4',
            "ville"=>'required|string|min:2',
            "pays"=>'required|string|min:2',
            "telephone"=>'required|string|min:9',
            "email"=>['required','string',new EmailExistRule($id,'Patient')],
            "quartier"=>'sometimes|nullable|string|min:1',
            "prenom"=>'sometimes|nullable|string|min:2',
            "code_postal"=>'sometimes|integer',
            "nom_contact"=>'sometimes|nullbale|string|min:2',
            "tel_contact"=>'sometimes|nullable|string|min:9',
            "lien_contact"=>'sometimes|nullable|string|min:4',
        ];
    }
}
