<?php

namespace App\Http\Requests;

use App\Rules\EmailExistRule;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class SouscripteurUpdateRequest extends FormRequest
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
            "sexe"=>["required",Rule::in(['M','F'])],
            "date_de_naissance"=>'sometimes|nullable|date|before_or_equal:'.Carbon::now()->format('Y-m-d'),
        ];
    }

}
