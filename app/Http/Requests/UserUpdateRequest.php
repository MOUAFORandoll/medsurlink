<?php

namespace App\Http\Requests;

use App\Rules\EmailExistRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class UserUpdateRequest extends FormRequest
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
        $slug = $this->route()->parameter('user');

        return [
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['sometimes','nullable', 'string', 'max:255'],
            'nationalite' => ['sometimes','nullable', 'string', 'max:255'],
            'quartier' => ['sometimes','nullable', 'string', 'max:255'],
            'code_postal' => ['sometimes','nullable', 'integer'],
            'ville' => ['required','string', 'max:255'],
            'pays' => ['required','string', 'max:255'],
            'telephone' => ['required','string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255',new EmailExistRule($slug,'User')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'adresse' => ['required', 'string','min:3'],
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        Request::merge(['error'=>$validator->errors()->getMessages()]);

    }
}
