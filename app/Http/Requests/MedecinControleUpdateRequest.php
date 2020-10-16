<?php

namespace App\Http\Requests;

use App\Rules\EmailExistRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class MedecinControleUpdateRequest extends FormRequest
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
            "specialite_id"=>'required|integer|exists:specialites,id',
            "numero_ordre"=>'sometimes|nullable|string',
            "civilite"=>["required",Rule::in(['M.','Mme/Mlle.','Dr.','Pr.'])],
        ];
    }
}
