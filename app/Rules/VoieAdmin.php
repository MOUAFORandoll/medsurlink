<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class VoieAdmin implements Rule
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
            strtoupper('Inhalation'),
            strtoupper('Instillation'),
            strtoupper('Vaginale'),
            strtoupper('Oculaire'),
            strtoupper('PO'),
            strtoupper('IV'),
            strtoupper('IM'),
            strtoupper('SC'),
            strtoupper('Intradermique'),
            strtoupper('Rectale'),
            strtoupper('Cutanée'),
            strtoupper('Sublinguale'),
            strtoupper('Transdermique'),
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
