<?php

namespace App\Rules;

use App\Models\DossierMedical;
use App\User;
use Illuminate\Contracts\Validation\Rule;

class IsMedicasure implements Rule
{

 /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $dossier = DossierMedical::find($value);
        return  $dossier->patient->user->isMedicasure == 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This :attribute is not a Medicasure file .';
    }
}
