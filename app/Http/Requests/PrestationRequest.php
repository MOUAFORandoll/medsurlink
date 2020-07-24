<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrestationRequest extends FormRequest
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
            'nom'=>'required|string',
            'prix'=>'sometimes|nullable|numeric',
            'categorie_id'=>'sometimes|nullable|integer|exists:categorie_prestations,id',
            'new_categorie'=>'sometimes|nullable|string'
        ];
    }
}
