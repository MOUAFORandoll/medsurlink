<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Netpok\Database\Support\RestrictSoftDeletes;

class EtablissementExercice extends Model
{
    use SoftDeletes;
    use RestrictSoftDeletes;

    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = ['praticiens'];

    protected $fillable = [
        "name",
        "description",
        'slug'

    ];

    public function praticiens(){
        return $this->belongsToMany(Praticien::class,'etablissement_exercice_praticien','etablissement_id','praticien_id');
    }
}
