<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class ConclusionRequest extends FormRequest
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
            "consultation_medecine_generale_id"=>"required|integer|exists:consultation_medecine_generales,id",
            "reference"=>"required|string|min:3",
            "description"=>"required|string|min:3",
        ];
    }

}
