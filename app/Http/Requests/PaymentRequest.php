<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class PaymentRequest extends FormRequest
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
            "patient_id"=>'sometimes|nullable|integer|exists:patients,user_id',
            "souscripteur_id"=>'sometimes|nullable|integer|exists:souscripteurs,user_id',
            "amount"=>'sometimes|nullable|integer',
        ];
    }
}
