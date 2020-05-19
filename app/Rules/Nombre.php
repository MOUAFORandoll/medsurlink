<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Nombre implements Rule
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
            strtoupper('1'),
            strtoupper('2'),
            strtoupper('3'),
            strtoupper('4'),
            strtoupper('5'),
            strtoupper('6'),
            strtoupper('7'),
            strtoupper('8'),
            strtoupper('9'),
            strtoupper('10'),
            strtoupper('11'),
            strtoupper('12'),
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
