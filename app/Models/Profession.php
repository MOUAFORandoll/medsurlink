<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profession extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "name",
        "description"
    ];

    public function specialites(){
        return $this->hasMany(Specialite::class,'profession_id','id');
    }


}
