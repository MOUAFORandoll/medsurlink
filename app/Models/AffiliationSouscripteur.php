<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * App\Models\AffiliationSouscripteur
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $cim_id
 * @property string|null $type_contrat
 * @property string|null $nombre_paye
 * @property string|null $nombre_restant
 * @property string|null $montant
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $date_paiement
 * @property-read \App\Models\CommandePackage $commande
 * @property-read mixed $generate_slug
 * @property-read \App\Models\Souscripteur|null $souscripteur
 * @property-read \App\Models\Package|null $typeContrat
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur newQuery()
 * @method static \Illuminate\Database\Query\Builder|AffiliationSouscripteur onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur query()
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur whereCimId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur whereDatePaiement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur whereNombrePaye($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur whereNombreRestant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur whereTypeContrat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|AffiliationSouscripteur withTrashed()
 * @method static \Illuminate\Database\Query\Builder|AffiliationSouscripteur withoutTrashed()
 * @mixin \Eloquent
 */
class AffiliationSouscripteur extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
        'user_id',
        'cim_id',
        'type_contrat',
        'nombre_paye',
        'nombre_restant',
        'montant',
        'date_paiement',
        'slug',
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'generateSlug'
            ]

        ];
    }

    public function getGenerateSlugAttribute() {
        return Str::random(20).' '.Carbon::now()->timestamp;
    }

    public function souscripteur(){
        return $this->belongsTo(Souscripteur::class,'user_id','user_id');
    }
    public function typeContrat(){
        return $this->belongsTo(Package::class,'type_contrat','id');
    }

    public function commande(){
        return $this->belongsTo(CommandePackage::class, 'cim_id');
    }
}
