<?php

namespace App\Http\Requests;

use App\Rules\IsMedicasure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SuiviRequest extends FormRequest
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
            "dossier_medical_id"=>['required','integer','exists:dossier_medicals,id',new IsMedicasure],
            "responsable"=>"sometimes|nullable|integer|exists:users,id",
            "motifs"=>"sometimes|nullable|string",
            "etat"=>"required|string",
            "specialite.*.specialite_id"=>"required|integer|exists:specialites,id",
            "specialite.*.motifs"=>"sometimes|nullable|string",
            "specialite.*.etat"=>"required|nullable|string",
            "specialite.*.responsable"=>"sometimes|nullable|integer|exists:users,id",
        ];
    }
}
