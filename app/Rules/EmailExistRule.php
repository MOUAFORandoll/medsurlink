<?php

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;

class EmailExistRule implements Rule
{
    public $id;
    public $roleName;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id,$roleName)
    {
        $this->id = $id;
        $this->roleName = $roleName;
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
        $user = getUser($this->id,$this->roleName)->getOriginalContent()['user'];
//        Je vais regarder s'il existe un utilisateur avec cette email a part l'utilisateur qu'on veut modifier ses informations
        $nbre =   User::where('email','=',$value)->where('id','<>',$user->id)->count();
        return $nbre == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This :attribute is used.';
    }
}
