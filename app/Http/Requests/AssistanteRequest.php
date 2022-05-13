<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssistanteRequest extends FormRequest
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
            'nom'=>'sometimes|nullable|string',
            'prenom'=>'sometimes|nullable|string',
            'telephone'=>'sometimes|nullable|string',
            'email'=>'sometimes|nullable|string|email',
            'user_id'=>'sometimes|nullable|integer|exists:users,id',
            'etablissement_id'=>'required|exists:etablissement_exercices,id',
            'sexe'=>'sometimes|nullable|string',
        ];
    }
}
