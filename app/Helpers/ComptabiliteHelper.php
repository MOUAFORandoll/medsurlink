<?php

if(!function_exists('isComptable'))
{
    function isComptable($id = null) {
        is_null($id) ? $user_id = \Illuminate\Support\Facades\Auth::id() : $user_id = $id;

        $comptable =  \App\Models\Comptable::where('user_id',$user_id)->count();

        return $comptable > 0;
    }
}
