<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specialite extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "name",
        "description",
        "profession_id"
    ];
}
