<?php

namespace App\Traits;

use App\Http\Controllers\Traits\PersonnalErrors;

trait UserTrait
{

    /**
     * verifit si l'utilisateur est de la spécialité précisé
     *
     * @param null $user
     * @param string $specialite
     * @return void
     */
    public  function estIlSpecialisteDe($specialite,$user = null)
    {
        return estIlSpecialisteDe($specialite,$user);
    }
}
