<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "nom_feature",
        "guard_name",
    ];

    public function permissions()
    {
        return $this->hasMany('App\Permission');
    }
}
