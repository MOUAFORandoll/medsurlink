<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Netpok\Database\Support\RestrictSoftDeletes;

class Specialite extends Model
{
    use SoftDeletes;
    use RestrictSoftDeletes;

    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = ['medecinsControle'];

    protected $fillable = [
        "name",
        "description",
        "profession_id"
    ];

    public function profession(){
        return $this->belongsTo(Profession::class,'profession_id','id');
    }

    public function medecinsControle(){
        return $this->hasMany(MedecinControle::class,'specialite_id','id');
    }
}
