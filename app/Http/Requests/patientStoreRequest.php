<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class patientStoreRequest extends FormRequest
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
            "user_id"=>'sometimes|nullable|integer|exists:users,id',
            "souscripteur_id"=>'sometimes|nullable|integer|exists:souscripteurs,user_id',
            "sexe"=>["required",Rule::in(['M','F'])],
            "date_de_naissance"=>'required|date|before_or_equal:'.Carbon::now()->format('Y-m-d'),
            "nom_contact"=>'sometimes|nullbale|string|min:2',
            "tel_contact"=>'sometimes|nullable|string|min:9',
            "lien_contact"=>'sometimes|nullable|string|min:4',
            'etablissement_id.*'=>"required|integer|exists:etablissement_exercices,id"
        ];
    }
}
