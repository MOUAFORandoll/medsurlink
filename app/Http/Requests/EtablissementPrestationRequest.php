<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EtablissementPrestationRequest extends FormRequest
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
            'etablissement_id'=>'required|exists:etablissement_exercices,id',
            'prestation_id'=>'required|exists:prestations,id',
            'prix'=>'required|numeric',
            'reduction'=>'sometimes|nullable|string',
        ];
    }
}
