<?php
/**
 * verifit si l'utilisateur est de la spécialité précisé
 *
 * @param null $user
 * @param string $specialite
 * @return bool
 */
if(!function_exists('estIlSpecialisteDe')) {
    function estIlSpecialisteDe($specialite,$user = null)
    {

        if (is_null($user)){
            $user = \Illuminate\Support\Facades\Auth::user();
        }
        //Recupération du rôle de l'utilisateur
        $role = $user->getRoleNames()->first();

        //Evaluation pour le cas praticien
        if ($role == "Praticien"){
//            return $user->praticien->specialite->name == $specialite;
        }

        //Evaluation pour le cas Medecin contrôle
        if ($role == "Medecin controle"){
//            return $user->medecinControle->specialite->name == $specialite;
        }

        return false;

    }
}
