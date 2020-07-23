<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComptableRequest extends FormRequest
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
            'user_id'=>'required|integer|exists:users,id',
            'etablissement_id'=>'required|exists:etablissement_exercices,id',
            'sexe'=>'sometimes|nullable|string',
        ];
    }
}
