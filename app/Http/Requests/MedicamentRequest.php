<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicamentRequest extends FormRequest
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
            "nom_commercial"=>"required|string|unique:medicaments|max:100",
            "principe_actif"=>"required|string|max:100",
            "classe_medicamenteuse"=>"required|string|max:100",
            "forme_et_dosage"=>"required|string|max:100",
            "conditionement"=>"required|string|max:100",
        ];
    }
}
