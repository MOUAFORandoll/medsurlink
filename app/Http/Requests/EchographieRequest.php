<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class EchographieRequest extends FormRequest
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
            "consultation_obstetrique_id"=>"required|integer|exists:consultation_obstetriques,id",
            "type"=>"required|string",
            "ddr"=>"required|date|before_or_equal:".Carbon::now()->format('Y-m-d'),
            "dpa"=>"required|date|after_or_equal:".Carbon::now()->format('Y-m-d'),
            "semaine_amenorrhee"=>"required|integer",
            "date_creation"=>"sometimes|nullable|date",
            "biometrie"=>"sometimes|nullable|string",
            "annexe"=>"sometimes|nullable|string",
            "description"=>"sometimes|nullable|string",
        ];
    }
}
