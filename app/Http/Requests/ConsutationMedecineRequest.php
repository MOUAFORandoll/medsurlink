<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class ConsutationMedecineRequest extends FormRequest
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
            "dossier_medical_id"=>"required|integer|exists:dossier_medicals,id",
            "date_consultation"=>"sometimes|nullable|date|after_or_equal:".Carbon::now(),
            "anamese"=>"sometimes|nullable|string|min:5",
            "mode_de_vie"=>"sometimes|nullable|string|min:5",
            "motifs.*"=>"sometimes|integer|exists:motifs,id",
            "motifsACreer.*"=>"sometimes|string|min:2",
            "examen_clinique"=>"sometimes|nullable|string|min:2",
            "examen_complementaire"=>"sometimes|nullable|string|min:2",
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        Request::merge(['error'=>$validator->errors()->getMessages()]);

    }
}
