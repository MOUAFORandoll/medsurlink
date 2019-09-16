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
            "ddr"=>"required|date|after_or_equal:".Carbon::now(),
            "serologie"=>"sometimes|nullable|string",
            "groupe_sanguin"=>["sometimes", "nullable", "string", Rule::in(['A-', 'A+', 'B-', 'B+', 'AB-', 'AB+', 'O-', 'O+'])],
            "statut_socio_familiale"=>"sometimes|nullable|string",
            "assuetudes"=>"sometimes|nullable|string",
            "antecassuetudesedent_de_transfusion"=>"sometimes|nullable|string",
            "facteur_de_risque"=>"sometimes|nullable|string",
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        Request::merge(['error'=>$validator->errors()->getMessages()]);

    }
}
