<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientSouscripteurRequest extends FormRequest
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
            'financable_type'=>'required|string',
            'patient_id' => 'required|string|exists:patients,slug'
        ];

        if ($this->getRealMethod() == 'POST'){
            $rules['financable_id.*']='required|integer';
        }
        return $rules;
    }
}
