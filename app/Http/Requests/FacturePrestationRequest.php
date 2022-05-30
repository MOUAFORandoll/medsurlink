<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacturePrestationRequest extends FormRequest
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
            'facture_id'=>'required|integer|exists:factures,id',
            'date_prestation' => "required|date",
            'prestation_id' => "required|integer|exists:etablissement_prestation,id"

        ];
    }
}
