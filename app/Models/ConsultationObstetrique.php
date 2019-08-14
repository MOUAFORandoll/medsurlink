<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Netpok\Database\Support\RestrictSoftDeletes;

class ConsultationObstetrique extends Model
{
    use SoftDeletes;
    use RestrictSoftDeletes;

    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = ['consultationPrenatales','echographies'];

    protected $fillable = [
        "date_creation",
        "numero_grossesse",
        "ddr",
        "serologie",
        "groupe_sanguin",
        "statut_socio_familiale",
        "assuetudes",
        "antecassuetudesedent_de_transfusion",
        "facteur_de_risque",
        'archieved_at',
        'passed_at',
        'slug'
    ];

    public function consultationPrenatales(){
        return $this->hasMany(ConsultationPrenatale::class,'consultation_obstetrique_id','id');
    }
    public function echographies(){
        return $this->hasMany(Echographie::class,'consultation_obstetrique_id','id');
    }
}
