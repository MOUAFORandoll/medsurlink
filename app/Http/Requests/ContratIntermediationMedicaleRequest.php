<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContratIntermediationMedicaleRequest extends FormRequest
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
            "nomS"=>"required|string|min:1|max:255",
            "paysS"=>["required",Rule::in(['Cameroun','Belgique'])],
            "villeS"=>"required|string|min:1",
            "telephoneS1"=>"required|string|min:9",
            "telephoneS2"=>"sometimes|string|min:9",
            "emailS1"=>"required|string|email|max:255",
            "emailS2"=>"sometimes|nullable|string|email|max:255",
            "typeSous"=>["required",Rule::in(['Annuelle','One shot'])],
            "paysSous"=>["required",Rule::in(['Cameroun','Belgique'])],
            "sexeS"=>["required",Rule::in(['M','Mme'])],
            "nomP"=>"required|string|min:1|max:255",
            "prenomP"=>"sometimes|string|min:1|max:255",
            "sexeP"=>["required",Rule::in(['M','Mme'])],
            "nomA"=>"required|string|min:1|max:255",
            "sexeA"=>["required",Rule::in(['M','Mme'])],
            "ageA"=>"required|numeric",
            "paysA"=>["required",Rule::in(['Cameroun','Belgique'])],
            "lieuEtablissement"=>["required",Rule::in(['Douala','Irchonwelz'])],
            "villeA"=>"required|string|min:1|max:255",
            "birthdayA"=>"required|date",
            "telephoneA1"=>"required|string|min:9",
            "telephoneA2"=>"required|string|min:9",
            "contact1"=>"required|string|min:9",
            "contact2"=>"required|string|min:9",
            "nomContact"=>"required|string|min:1|max:255",
            "montantSous"=>["required","string"],
            "dateSignature"=>["required","date"],
        ];


    }
}
