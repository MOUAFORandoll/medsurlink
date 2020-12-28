<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultationMotifs extends Model
{
    use SoftDeletes;
    protected $table = ['consultation_motif'];
    protected $fillable = [
      "consultation_medecine_generale_id",
      "motif_id",
    ];
}
