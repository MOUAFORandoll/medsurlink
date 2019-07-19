<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Affiliation extends Model
{
    use SoftDeletes;

    protected $fillable = [
      "patient_id",
      "nom",
      "date_debut",
      "date_fin",
    ];

    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id','id');
    }
}
