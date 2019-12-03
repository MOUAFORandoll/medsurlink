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
        $rules = [
            "dossier_medical_id"=>"required|integer|exists:dossier_medicals,id",
            "conclusions"=>"sometimes|nullable|string|min:2",
            "anamese"=>"sometimes|nullable|string|min:5",
            "mode_de_vie"=>"sometimes|nullable|string|min:5",
            "examen_clinique"=>"sometimes|nullable|string|min:2",
            "examen_complementaire"=>"sometimes|nullable|string|min:2",
            "traitement_propose"=>"sometimes|nullable|string|min:2",
            "profession"=>"sometimes|nullable|string|min:2",
            "situation_familiale"=>"sometimes|nullable|string|min:2",
            "nbre_enfant"=>"sometimes|nullable|string|min:1",
            "tabac"=>"sometimes|nullable|string|min:2",
            "alcool"=>"sometimes|nullable|string|min:2",
            "autres"=>"sometimes|nullable|string|min:2",
        ];

        if($this->isMethod('POST'))
        {
            $rules["motifs.*"] = 'required';
            $rules["date_consultation"]="sometimes|nullable|date|after_or_equal:".Carbon::now()->format('Y-m-d');

        }

        elseif ($this->isMethod('PUT')){
            $rules["motifs.*"] = 'sometimes|nullable|string|min:1';
            $rules["date_consultation"]="sometimes|nullable|date";
        }

        return $rules;
    }
}
