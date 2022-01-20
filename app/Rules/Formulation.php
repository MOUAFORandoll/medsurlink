<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Formulation implements Rule
{
    public $elementsAcceptes;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->elementsAcceptes = [
            strtoupper('Application'),
            strtoupper('Ampoule'),
            strtoupper('Collyre'),
            strtoupper('Comprime'),
            strtoupper('gelule'),
            strtoupper('Goutte'),
            strtoupper('Ovule'),
            strtoupper('Sachet'),
            strtoupper('Suppositoire'),
            strtoupper('ml'),
            strtoupper('mg'),
        ];
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return in_array(strtoupper($value), $this->elementsAcceptes);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
         return 'The :attribute must be element of '.implode(',',$this->elementsAcceptes);
    }
}
