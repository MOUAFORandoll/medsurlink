<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class AntecedentRequest extends FormRequest
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
            "description"=>"required|string|min:3",
            "date"=>"sometimes|nullable|date|before_or_equal:".Carbon::now()->format('Y-m-d'),
            "type"=>"required|string|min:2",
        ];
    }

}
