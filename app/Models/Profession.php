<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Netpok\Database\Support\RestrictSoftDeletes;

class Profession extends Model
{
    use SoftDeletes;
    use RestrictSoftDeletes;

    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = ['specialites'];

    protected $fillable = [
        "name",
        "description"
    ];

    public function specialites(){
        return $this->hasMany(Specialite::class,'profession_id','id');
    }


}
