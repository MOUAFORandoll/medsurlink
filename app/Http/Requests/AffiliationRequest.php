<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class AffiliationRequest extends FormRequest
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
            "patient_id"=>"required|integer|exists:patients,user_id",
            "nom"=>["required",Rule::in(['One shot','Annuelle'])],
            "date_debut"=>"required|date|after_or_equal:".Carbon::now()->format('Y-m-d'),
            "date_fin"=>"sometimes|nullable|date|after_or_equal:date_debut",
        ];
    }

}
