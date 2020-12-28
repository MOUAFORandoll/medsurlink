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
    public function __construct($slug,$roleName)
    {
        $this->slug = $slug;
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
        $user = getUser($this->slug,$this->roleName)->getOriginalContent()['user'];
//        Je vais regarder s'il existe un utilisateur avec cette email a part l'utilisateur qu'on veut modifier ses informations
        $nbre =   User::where('email','=',$value)->where('slug','not like',$user->slug)->count();
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
