<?php

if(!function_exists('checkIfPrestationExist'))
{
    function checkIfPrestationExist($prestation_id, $etablissement,$prix, $reduction) {
           $prestation = \App\Models\EtablissementPrestation::
                where('prestation_id',$prestation_id)
                ->where('etablissement_id',$etablissement)
                ->where('prix',$prix)
                ->where('reduction',$reduction)
                ->count();
           return $prestation == 0;
    }
}
