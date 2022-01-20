<?php

namespace App\Traits;

use App\Models\DossierMedical;
use Carbon\Carbon;

trait DossierTrait
{
    public function updateDossierId($id){
        $dossier = DossierMedical::whereId($id)->first();
        if (!is_null($dossier)){
            $dossier->updated_at = Carbon::now()->format('Y-m-d H:i:s');
            $dossier->save();
        }
    }
}
