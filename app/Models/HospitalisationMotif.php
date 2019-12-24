<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HospitalisationMotif extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "hospitalisation_id",
        "motif_id",
    ];
}
