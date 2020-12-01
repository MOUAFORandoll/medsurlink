<?php

if(!function_exists('dateFormat')) {
    function dateFormat($date)
    {
        return Carbon\Carbon::parse($date)->format('d/m/Y');
    }
}
