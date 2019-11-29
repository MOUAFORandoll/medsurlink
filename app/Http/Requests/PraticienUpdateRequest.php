<?php

namespace App\Http\Requests;

use App\Rules\EmailExistRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class PraticienUpdateRequest extends FormRequest
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
            "profession_id"=>'required|integer|exists:professions,id',
            "specialite_id"=>'required|integer|exists:specialites,id',
            //"etablissement_id"=>'sometimes|nullable|integer|exists:etablissement_exercices,id',
            "numero_ordre"=>'sometimes|nullable|string|min:6',
            "civilite"=>["required",Rule::in(['M.','Mme/Mlle.','Dr.','Pr.'])],
        ];
    }
}
