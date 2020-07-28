<?php

namespace App\Http\Requests;

use App\Models\Prestation;
use Illuminate\Foundation\Http\FormRequest;

class PrestationRequest extends FormRequest
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
            'prix'=>'sometimes|nullable|numeric',
            'categorie_id'=>'sometimes|nullable|integer|exists:categorie_prestations,id',
            'new_categorie'=>'sometimes|nullable|string'
        ];
        if ($this->method() == 'PUT'){

            $prestation = Prestation::whereSlug($this->request->get('prestation'))->first();
            if (!is_null($prestation)){
                $rules['nom'] = 'required|string|unique:prestations,nom,'.$prestation->id;
            }else{
                $rules['nom'] = 'required|string|unique:prestations,nom';
            }
        }

        if ($this->method() == 'POST'){
            $rules['nom'] = 'sometimes|nullable|string|unique:prestations,nom';
        }

         return  $rules;
    }
}
