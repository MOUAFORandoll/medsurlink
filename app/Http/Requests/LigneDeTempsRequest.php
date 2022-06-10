<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LigneDeTempsRequest extends FormRequest
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
            "dossier_medical_id"=>'sometimes|nullable|string',
            "motif_consultation_id"=>'sometimes|nullable|string',
            "date_consultation"=>'sometimes|nullable|string',
            "etat"=>'sometimes|nullable|string',
            'affiliation_id' => 'nullable'
        ];
    }
}
