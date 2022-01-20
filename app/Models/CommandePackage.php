<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommandePackage extends Model
{
    use SoftDeletes;

    protected $table = "offres_packages_commandes";

    protected $fillable = [
        "date_commande",
        'statut',
        'quantite',
        'offres_packages_id',
        'souscripteur_id'
    ];

}
