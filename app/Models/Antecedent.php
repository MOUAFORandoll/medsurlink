<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Antecedent extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "consultation_medecine_generale_id",
        "description",
        "date",
        "type",
        'slug'
    ];

    public function consultation(){
        return $this->belongsTo(ConsultationMedecineGenerale::class,'consultation_medecine_generale_id','id');
    }
}
