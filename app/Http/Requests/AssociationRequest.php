<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssociationRequest extends FormRequest
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
            "region"=>"sometimes|nullable|string",
            "ville"=>"sometimes|nullable|string",
            "nom"=>"sometimes|nullable|string",
            "localisation"=>"sometimes|nullable|string",
            "telephone"=>"sometimes|nullable|string",
            "email"=>"sometimes|nullable|email",
            "contact"=>"sometimes|nullable|string",
        ];
    }
}
