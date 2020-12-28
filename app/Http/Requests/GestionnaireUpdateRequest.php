<?php

namespace App\Http\Requests;

use App\Models\Gestionnaire;
use App\Rules\EmailExistRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

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
        $rules["civilite"] = ["required",Rule::in(['M.','Mme/Mlle.','Dr.','Pr.'])];
        return $rules ;
    }
}
