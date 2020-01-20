<?php

namespace App\Http\Requests;

use App\Http\Controllers\Api\ConsultationObstetriqueController;
use App\Models\ConsultationObstetrique;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class ConsultationObstetriqueRequest extends FormRequest
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
            "ddr"=>"required|date|before_or_equal:".Carbon::now()->format('Y-m-d'),
            "serologie.*"=>"sometimes|nullable|string",
            "groupe_sanguin"=>["sometimes", "nullable", "string", Rule::in(['A-', 'A+', 'B-', 'B+', 'AB-', 'AB+', 'O-', 'O+'])],
            "statut_socio_familiale"=>"sometimes|nullable|string",
            "assuetudes"=>"sometimes|nullable|string",
            "antecassuetudesedent_de_transfusion"=>"sometimes|nullable|string",
            "facteur_de_risque"=>"sometimes|nullable|string",
            "antecedent_conjoint"=>"sometimes|nullable|string|min:2",
            "pcr_gonocoque"=>"sometimes|nullable|string",
            "pcr_chlamydia"=>"sometimes|nullable|string",
            "rcc.*"=>"sometimes|nullable|string",
            "glycemie"=>"sometimes|nullable|string|numeric",
            "emu"=>"sometimes|nullable|string",
            "tsh"=>"sometimes|nullable|string|numeric",
            "anti_tpo"=>"sometimes|nullable|string|numeric",
            "ft4"=>"sometimes|nullable|string|numeric",
            "ft3"=>"sometimes|nullable|string|numeric",
            "attention"=>"sometimes|nullable|string",
            "info_prise_en_charge"=>"sometimes|nullable|string",
            'etablissement_id'=>'required|integer|exists:etablissement_exercices,id',
            "t1"=>"sometimes|nullable|string",
            "nle_anle"=>"sometimes|nullable|string",
            "sexe"=>"sometimes|nullable|string",
        ];
    }
}
