<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamenCardioRequest extends FormRequest
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
            'nom'=>"required|string|max:20",
            "date_examen"=>'required|date',
            "description"=>"required|string|max:255",
        ];

        if ($this->getMethod() == 'POST'){
            $rules['cardiologie_id']='required|string|exists:cardiologies,slug';
        }

        return $rules;
    }
}
