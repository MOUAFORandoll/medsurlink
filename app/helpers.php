<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


/**
 * Fonction permettant de determiner si on a déjà archivé un element lié au user
 * @param $user
 * @return int
 */
//if (!function_exists('hasArchivedElement')){
//
//    function hasArchivedElement($user){
//        $age = Carbon::today()->diffInYears(Carbon::parse($date_de_naissance));
//        return $age;
//    }
//}

/**
 * Fonction permettant de calculer l'age lié a la date passé en parametre
 * @param $date_de_naissance
 * @return int
 */
if (!function_exists('evaluateYearOfOld')) {

    function evaluateYearOfOld($date_de_naissance)
    {
        if (!is_null($date_de_naissance)) {
            $age = Carbon::today()->diffInYears(Carbon::parse($date_de_naissance));
            return $age;
        }
        return 0;
    }
}

/**
 * Fonction qui concatenne en majuscule le nom lié à la requette et met en majuscule la premiere lettre du prenom et retourne
 * @param \Illuminate\Http\Request $request
 * @return string
 */
if (!function_exists('fullName')) {

    function fullName(\Illuminate\Http\Request $request)
    {
        return strtoupper($request->nom) . ' ' . ucfirst($request->prenom);
    }
}

/**
 * Fonction qui permet de verifie si l'identifiant passé en parametre existe dans la table spécifié
 * @param $id
 * @param $table
 * @return \Illuminate\Http\JsonResponse|null
 */
if (!function_exists('validatedSlug')) {

    function validatedSlug($slug, $table)
    {
        $validation = Validator::make(compact('slug'), ['slug' => 'exists:' . $table . ',slug']);
        if ($validation->fails()) {
            throw new ValidationException($validation, $validation->errors()->messages());
        }
        return null;
    }
}

/**
 * Fonction qui retourne la date actuel au format Y-m-d
 * @return string
 */
if (!function_exists('dateOfToday')) {

    function dateOfToday()
    {
        return Carbon::now()->format('Y-m-d');
    }
}

/**
 * Fonction qui permet de définir un utilisateur comme celui qui a éffectué l'opetation "action" sur l'enregistrement "operationable_id" de la table "operationable_type"
 * @param $operationable_type
 * @param $operationable_id
 * @param $action
 */
if (!function_exists('defineAsAuthor')) {

    function defineAsAuthor($operationable_type, $operationable_id, $action, $patient_id = null)
    {
        $status = getStatus();
        $auteurable_type = $status->getOriginalContent()['auteurable_type'];
        $auteurable_id = $status->getOriginalContent()['auteurable_id'];
        \App\Http\Controllers\Api\AuteurController::store($auteurable_type, $auteurable_id, $operationable_type, $operationable_id, $action, $patient_id);
    }
}

/**
 * Fonction qui retourne le role de l'utilisateur courant ainsi que son id dans la table ou il a ce rôle là
 * @return \Illuminate\Http\JsonResponse
 */
if (!function_exists('getStatus')) {

    function getStatus($user = null)
    {
        if (is_null($user)) {
            $user = \Illuminate\Support\Facades\Auth::user();
        }
        $auteurable_type = $user->getRoleNames()->first();
        if (!is_null($auteurable_type)) {
            $status = getStatusUserRole($auteurable_type, $user)->getOriginalContent()['auteurable_user'];
            if ($status == null) {
                return null;
            }
            $auteurable_id = $status->user_id;
            return response()->json(['auteurable_type' => $auteurable_type, 'auteurable_id' => $auteurable_id,]);
        } else {
            return response()->json(['auteurable_type' => 'Comptable', 'auteurable_id' => $user->id]);
        }
    }
}

/**
 * Fonction qui retourne les informations personnels de l'utilisateur lié au rôle spécifié
 * @param $roleName
 * @param $user
 * @return \Illuminate\Http\JsonResponse
 */
if (!function_exists('getStatusUserRole')) {
    function getStatusUserRole($roleName, $user)
    {
        if ($roleName == "Praticien") {
            return response()->json(['auteurable_user' => $user->praticien]);
        } elseif ($roleName == "Patient") {
            return response()->json(['auteurable_user' => $user->patient]);
        } elseif ($roleName == "Gestionnaire") {
            return response()->json(['auteurable_user' => $user->gestionnaire]);
        } elseif ($roleName == "Souscripteur") {
            return response()->json(['auteurable_user' => $user->souscripteur]);
        } elseif ($roleName == "Medecin controle") {
            return response()->json(['auteurable_user' => $user->medecinControle]);
        } elseif ($roleName == "Etablissement") {
            return response()->json(['auteurable_user' => $user]);
        } elseif ($roleName == "Admin") {
            return response()->json(['auteurable_user' => $user]);
        } elseif ($roleName == "Association") {
            return response()->json(['auteurable_user' => $user]);
        } elseif ($roleName == "Assistante") {
            return response()->json(['auteurable_user' => $user->assistante]);
        } elseif ($roleName == "Pharmacien") {
            return response()->json(['auteurable_user' => $user->pharmacien]);
        } elseif ($roleName == "Patient-Alerte") {
            return response()->json(['auteurable_user' => $user]);
        } elseif ($roleName == "Directeur") {
            return response()->json(['auteurable_user' => $user]);
        }
    }
}

/** Fonction permettant de determiner si un utilisateur est autorisé à modifier une ressource ou pas
 * @param $operationable_type
 * @param $operationable_id
 * @param $action
 * @return \Illuminate\Http\JsonResponse
 */
if (!function_exists('checkIfIsAuthorOrIsAuthorized')) {

    function checkIfIsAuthorOrIsAuthorized($operationable_type, $operationable_id, $action)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $nbre  = 0;

        if ($user->getRoleNames()->first() != "Admin") {
            //Recuperation du role de celui qui a crée l'element
            $role = getAuthorRole($operationable_type, $operationable_id, $action);
            $auteurId = getAuthorId($operationable_type, $operationable_id, $action);
            if (!is_null($role) && !is_null($auteurId)) {
                $userStatusId = getStatus();
                //verification avec le role de celui qui veut y accéder
                if (($role == $user->getRoleNames()->first()) and ($auteurId == $userStatusId->getOriginalContent()['auteurable_id'])) {
                    $nbre = 1;
                }
            }
        } else {
            $nbre = 1;
        }
        if ($nbre > 0)
            return response()->json(true);
        return response()->json(false);
    }
}

if (!function_exists('checkIfCanUpdated')) {

    function checkIfCanUpdated($operationable_type, $operationable_id, $action)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $nbre  = 0;
        //Recuperation du role de celui qui a crée l'element
        $role = getAuthorRole($operationable_type, $operationable_id, $action);
        $isAuthor = checkIfIsAuthorOrIsAuthorized($operationable_type, $operationable_id, $action);
        if ($isAuthor->getOriginalContent() == false) {
            if (($role == 'Praticien' &&  $user->getRoleNames()->first() == 'Medecin controle' &&  $user->getRoleNames()->first() == 'Assistante') || ($role == 'Medecin controle' && $role == 'Assistante' && $user->getRoleNames()->first() == 'Medecin controle' && $user->getRoleNames()->first() == 'Assistante')) {
                $nbre = 1;
            }
        } else {
            $nbre = 1;
        }
        if ($nbre > 0)
            return response()->json(true);
        return response()->json(false);
    }
}

/** Fonctionne qui retourne le role de l'utilisateur ayant éffectué l'operation "action" sur l'enregistrement "operationable_id" de la table "operationable_type"
 * @param $operationable_type
 * @param $operationable_id
 * @param $action
 * @return mixed
 */
if (!function_exists('getAuthorRole')) {

    function getAuthorRole($operationable_type, $operationable_id, $action)
    {
        $auteur =   \App\Models\Auteur::where('action', '=', $action)->where('operationable_type', '=', $operationable_type)->where('operationable_id', '=', $operationable_id)->first();
        if (is_null($auteur))
            return null;
        return $auteur->auteurable_type;
    }
}

if (!function_exists('getAuthorId')) {

    function getAuthorId($operationable_type, $operationable_id, $action)
    {
        $auteur =   \App\Models\Auteur::where('action', '=', $action)->where('operationable_type', '=', $operationable_type)->where('operationable_id', '=', $operationable_id)->first();
        if (is_null($auteur))
            return null;
        return $auteur->auteurable_id;
    }
}

if (!function_exists('getAuthor')) {
    function getAuthor($operationable_type, $operationable_id, $action)
    {
        $auteur =   \App\Models\Auteur::with('user')->where('action', '=', $action)->where('operationable_type', '=', $operationable_type)->where('operationable_id', '=', $operationable_id)->first();
        if (is_null($auteur))
            return null;
        return $auteur;
    }
}

if (!function_exists('getUpdatedAuthor')) {
    function getUpdatedAuthor($operationable_type, $operationable_id, $action)
    {
        $auteur =   \App\Models\Auteur::where('action', 'like', '%' . $action . '%')->where('operationable_type', '=', $operationable_type)->where('operationable_id', '=', $operationable_id)->distinct()->get();
        if (is_null($auteur))
            return null;
        return $auteur;
    }
}


if (!function_exists('getUser')) {

    function getUser($slug, $roleName)
    {
        if ($roleName == "Praticien") {
            $praticien = \App\Models\Praticien::whereSlug($slug)->first();
            return response()->json(['user' => $praticien->user]);
        } elseif ($roleName == "Patient") {
            $patient = \App\Models\Patient::whereSlug($slug)->first();
            return response()->json(['user' => $patient->user]);
        } elseif ($roleName == "Gestionnaire") {
            $gestionnaire = \App\Models\Gestionnaire::whereSlug($slug)->first();
            return response()->json(['user' => $gestionnaire->user]);
        } elseif ($roleName == "Souscripteur") {
            $souscripteur = \App\Models\Souscripteur::whereSlug($slug)->first();
            return response()->json(['user' => $souscripteur->user]);
        } elseif ($roleName == "Medecin controle") {
            $medecinControle = \App\Models\MedecinControle::whereSlug($slug)->first();
            return response()->json(['user' => $medecinControle->user]);
        } elseif ($roleName == "Association") {
            $association = \App\Models\Association::whereSlug($slug)->first();
            return response()->json(['user' => $association->userResponsable]);
        } elseif ($roleName == "Admin") {
            $user = \App\User::find(1);
            return response()->json(['user' => $user]);
        } elseif ($roleName == "User") {
            $user = \App\User::findBySlug($slug);
            return response()->json(['user' => $user]);
        } elseif ($roleName == "Assistante") {
            $assistante = \App\Models\Assistante::whereSlug($slug)->first();
            return response()->json(['user' => $assistante->user]);
        } elseif ($roleName == "Pharmacien") {
            $pharmacien = \App\Models\Pharmacien::whereSlug($slug)->first();
            return response()->json(['user' => $pharmacien->user]);
        }
    }
}
