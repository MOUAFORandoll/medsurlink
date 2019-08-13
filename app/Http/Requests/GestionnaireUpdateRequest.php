<?php

namespace App\Http\Requests;

use App\Rules\EmailExistRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GestionnaireUpdateRequest extends FormRequest
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
        $id = $this->route()->parameter('gestionnaire');
        return [
            "user_id"=>'sometimes|integer|exists:users,id',
            "civilite"=>["required",Rule::in(['M.','Mme/Mlle.','Dr.','Pr.'])],
//            "nationalite"=>'required|string|min:4',
//            "ville"=>'required|string|min:2',
//            "pays"=>'required|string|min:2',
//            "telephone"=>'required|string|min:9',
//            "email"=>['required','string',new EmailExistRule($id,'Gestionnaire')],
//            "quartier"=>'sometimes|nullable|string|min:1',
//            "prenom"=>'sometimes|nullable|string|min:2',
//            "code_postal"=>'sometimes|integer',
//            "nom"=>'required|string|min:2',
        ];
    }
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        return response()->json(['error'=>$validator->errors()],419);
    }

}
