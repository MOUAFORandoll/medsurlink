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
            "nomS"=>"required|string|min:1|max:20",
            "paysS"=>["required",Rule::in(['Cameroun','Belgique'])],
            "villeS"=>"required|string|min:1|max:15",
            "telephoneS1"=>"required|string|min:9",
            "telephoneS2"=>"sometimes|string|min:9",
            "emailS1"=>"required|string|email|max:50",
            "emailS2"=>"sometimes|nullable|string|email|max:50",
            "typeSous"=>["required",Rule::in(['Annuelle','One shot'])],
            "paysSous"=>["required",Rule::in(['Cameroun','Belgique'])],
            "sexeS"=>["required",Rule::in(['M','Mme'])],
            "nomP"=>"required|string|min:1|max:20",
            "prenomP"=>"sometimes|string|min:1|max:20",
            "sexeP"=>["required",Rule::in(['M','Mme'])],
            "nomA"=>"required|string|min:1|max:20",
            "sexeA"=>["required",Rule::in(['M','Mme'])],
            "ageA"=>"required|numeric",
            "paysA"=>["required",Rule::in(['Cameroun','Belgique'])],
            "lieuEtablissement"=>["required",Rule::in(['Douala','Irchonwelz'])],
            "villeA"=>"required|string|min:1|max:20",
            "birthdayA"=>"required|date",
            "telephoneA1"=>"required|string|min:9",
            "telephoneA2"=>"required|string|min:9",
            "contact1"=>"required|string|min:9",
            "contact2"=>"required|string|min:9",
            "nomContact"=>"required|string|min:1|max:20",
            "montantSous"=>["required","string"],
            "dateSignature"=>["required","date"],
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        return response()->json(['error'=>$validator->errors()],419);
    }
}
