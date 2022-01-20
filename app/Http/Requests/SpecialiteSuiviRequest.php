<?php

namespace App\Http\Requests;

use App\Rules\IsMedicasure;
use Illuminate\Foundation\Http\FormRequest;

class SpecialiteSuiviRequest extends FormRequest
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
            "suivi_id"=>"required|integer|exists:suivis,id",
            "specialite_id"=>"required|integer|exists:consultation_types,id",
            "motifs"=>"sometimes|nullable|string",
            "etat"=>"required|nullable|string",
            "responsable"=>"sometimes|nullable|integer|exists:users,id",
        ];
    }
}
