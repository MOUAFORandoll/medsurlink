<?php

namespace App\Http\Requests;

use App\Models\Prestation;
use Illuminate\Foundation\Http\FormRequest;

class EtablissementPrestationRequest extends FormRequest
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
        $rules =
            [
                'etablissement_id'=>'required|integer|exists:etablissement_exercices,id',
                'prestation_id'=>'sometimes|nullable|integer|exists:prestations,id',
                'prix'=>'required|numeric',
                'reduction'=>'sometimes|nullable|string',
                'categorie_id'=>'sometimes|nullable|integer|exists:categorie_prestations,id',
                'new_categorie'=>'sometimes|nullable|string|unique:categorie_prestations,nom'
            ];


        if ($this->method() == 'PUT'){

            $prestation = Prestation::whereId($this->request->get('prestation_id'))->first();
            if (!is_null($prestation)){
                $rules['nom'] = 'required|string|unique:prestations,nom,'.$prestation->id;
            }else{
                $rules['nom'] = 'required|string|unique:prestations,nom';
            }
        }

        if ($this->method() == 'POST'){
            $rules['nom'] = 'sometimes|nullable|string|unique:prestations,nom';
        }

        return $rules;
    }
}
