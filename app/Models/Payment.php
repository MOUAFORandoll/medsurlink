<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Netpok\Database\Support\RestrictSoftDeletes;

class Payment extends Model
{
    use SoftDeletes;
    use Sluggable;

    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = ['payments'];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';


    protected $fillable = [
        "motif",
        "amount",
        "souscripteur_id",
        "patient_id",
        "date_payment",
        "statut",
        "method",
        'slug'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'TypeAndTimestamp'
            ]
        ];
    }
    public function patients(){
        return $this->belongsTo(Patient::class,'patient_id','user_id');
    }

    public function souscripteur(){
        return $this->belongsTo(Souscripteur::class,'souscripteur_id','user_id');
    }
}
