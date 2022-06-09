<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cloture extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'cloturable_id',
        'cloturable_type',
        'automatique',
        'ama',
        'medecin_referent',
        'gestionnaire'
    ];

    public function cloturable(){
        return $this->morphTo();
    }

}
