<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auteur extends Model
{
    use SoftDeletes;

    protected $fillable =[
        "auteurable_type",
        "auteurable_id",
        "operationable_type",
        "operationable_id",
        "action",
        "user_id",
        "patient_id",
    ];

    /**
     * Get the owning auteurable model.
     */
    public function auteurable()
    {
        return $this->morphTo();
    }
    /**
     * Get the owning operationable model.
     */
    public function operationable()
    {
        return $this->morphTo();
    }

    public function patient(){
        return $this->belongsTo(User::class,'patient_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
