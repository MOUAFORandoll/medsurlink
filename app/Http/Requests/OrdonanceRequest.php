<?php

namespace App\Http\Requests;

use App\Rules\Formulation;
use App\Rules\Nombre;
use App\Rules\Par;
use App\Rules\VoieAdmin;
use Illuminate\Foundation\Http\FormRequest;

class OrdonanceRequest extends FormRequest
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
        $rules =  [
            'dossier_medical_id'=>'required|exists:dossier_medicals,slug',
            'date_prescription'=>'required|date',
//            'medicaments.*.*'=>'required|integer|exists:medicaments,id'
        ];

        if ($this->getMethod() == 'POST'){
            $rules['prescription.*.medicament_id'] ='required|integer|exists:medicaments,id';
            $rules['prescription.*.info_comp'] ='sometimes|nullable|string|max:255';
            $rules['prescription.*.date_fin'] ='required|date';
            $rules['prescription.*.posologie.dose'] ='required|numeric';
            $rules['prescription.*.posologie.formulation'] = ['required','string',new Formulation];
            $rules['prescription.*.posologie.voieAdmin'] =['required','string',new VoieAdmin];
            $rules['prescription.*.posologie.nombre'] =['required','string',new Nombre];
            $rules['prescription.*.posologie.par'] =['required','string',new Par];
        }
        return  $rules;


    }
}
