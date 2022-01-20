<?php

namespace App\Http\Requests;

use App\Rules\EmailExistRule;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
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
            "souscripteur_id"=>'sometimes|integer|exists:souscripteurs,user_id',
            "sexe"=>["required",Rule::in(['M','F'])],
            "date_de_naissance"=>'required|date|before_or_equal:'.Carbon::now()->format('Y-m-d'),
            "code_postal"=>'sometimes|nullable|string',
            "nom_contact"=>'sometimes|nullable|string|min:2',
            "tel_contact"=>'sometimes|nullable|string|min:9',
            "lien_contact"=>'sometimes|nullable|string|min:4',
            'question_id'=>'nullable|integer|exists:questions,id',
            'reponse'=>'nullable|string|min:3'
      ];
    }
}
