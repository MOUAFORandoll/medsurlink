<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\CommandePackage
 *
 * @property int $id
 * @property int $offres_packages_id
 * @property int $souscripteur_id
 * @property string $quantite
 * @property string $date_commande
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Package $offres_package
 * @property-read \App\Models\Souscripteur $souscripteur
 * @method static \Illuminate\Database\Eloquent\Builder|CommandePackage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommandePackage newQuery()
 * @method static \Illuminate\Database\Query\Builder|CommandePackage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CommandePackage query()
 * @method static \Illuminate\Database\Eloquent\Builder|CommandePackage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommandePackage whereDateCommande($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommandePackage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommandePackage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommandePackage whereOffresPackagesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommandePackage whereQuantite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommandePackage whereSouscripteurId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommandePackage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|CommandePackage withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CommandePackage withoutTrashed()
 * @mixin \Eloquent
 */
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

    public function souscripteur(){
        return $this->belongsTo(Souscripteur::class, 'souscripteur_id');
    }

    public function offres_package(){
        return $this->belongsTo(Package::class, 'offres_packages_id');
    }


}
