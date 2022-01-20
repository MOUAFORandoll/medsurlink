<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentOffre extends Model
{
    use SoftDeletes;

    protected $table = "offres_payments";

    protected $fillable = [
        "date_payment",
        "montant",
        'status',
        'commande_id',
        'souscripteur_id'
    ];

}
