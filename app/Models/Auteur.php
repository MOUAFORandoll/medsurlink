<?php

namespace App\Models;

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
}
