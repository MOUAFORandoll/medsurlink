<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DossierMedical extends Model
{
    use SoftDeletes;

    protected $fillable = [
      "patient_id",
      "date_de_creation",
      "numero_dossier",
    ];

    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id','user_id');
    }
}
