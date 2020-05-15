<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RendezVousRequest extends FormRequest
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
            "sourceable_id"=>'sometimes|nullable|integer',
            "sourceable_type"=>'sometimes|nullable|string',
            "patient_id"=>'required|integer|exists:users,id',
            "praticien_id"=>'required|integer|exists:users,id',
            "motifs"=>'sometimes|nullable|string|max:500',
            "date"=>'required|date_format:Y-m-d H:i',
            "statut"=>'sometimes|nullable|string',
        ];
    }
}
