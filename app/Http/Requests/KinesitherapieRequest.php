<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KinesitherapieRequest extends FormRequest
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
            "etablissement_id"=>'sometimes|nullable|string',
            "creator"=>'sometimes|nullable|string',
            "dossier_medical_id"=>'sometimes|nullable|string',
            "date_consultation"=>'sometimes|nullable|string',
            "motifs"=>'sometimes|nullable|string',
            "anamnese"=>'sometimes|nullable|string',
            "profession"=>'sometimes|nullable|string',
            "evaluation_globale"=>'sometimes|nullable|string',
            "impression_diagnostique"=>'sometimes|nullable|string',
            "examens_complementaires"=>'sometimes|nullable|string',
            "conduite_a_tenir"=>'sometimes|nullable|string',
            "archieved_at"=>'sometimes|nullable|string',
            "passed_at"=>'sometimes|nullable|string',
            "contributeurs.*" => "sometimes|nullable|integer",
            "dateRdv" => "sometimes|nullable|string",
            "motifRdv" => "sometimes|nullable|string",
            "praticien_id"=>'sometimes|nullable|string',
        ];
    }
}
