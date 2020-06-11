<?php

namespace App\Http\Requests;

use App\Rules\isNotice;
use Illuminate\Foundation\Http\FormRequest;

class AvisRequest extends FormRequest
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
            "dossier_medical_id"=>['required','integer','exists:dossier_medicals,id'],
            "objet"=>'required|string',
            "description"=>'required|string',
            "creer_lien"=>'required|string',
            "medecins.*"=>['sometimes','nullable','integer','exists:users,id',new isNotice]
        ];
    }
}
