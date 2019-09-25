<?php

namespace App\Http\Requests;

use App\Rules\EmailExistRule;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class SouscripteurUpdateRequest extends FormRequest
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
        $slug = $this->route()->parameter('souscripteur');

        return [
            "sexe"=>["required",Rule::in(['M','F'])],
            "date_de_naissance"=>'required|date|before_or_equal:'.Carbon::now()->format('Y-m-d'),
   ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        Request::merge(['error'=>$validator->errors()->getMessages()]);
    }
}
