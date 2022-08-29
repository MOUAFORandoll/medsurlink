<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * App\Models\NotificationPaiement
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $code_contrat
 * @property string|null $pay_token
 * @property string|null $statut
 * @property string|null $reponse
 * @property string|null $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $generate_slug
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement newQuery()
 * @method static \Illuminate\Database\Query\Builder|NotificationPaiement onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement whereCodeContrat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement wherePayToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement whereReponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|NotificationPaiement withTrashed()
 * @method static \Illuminate\Database\Query\Builder|NotificationPaiement withoutTrashed()
 * @mixin \Eloquent
 */
class NotificationPaiement extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
      "type",
      "code_contrat",
      "pay_token",
      "statut",
      "reponse",
      "slug",
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
        return Str::random(5).' '.Carbon::now()->timestamp;
    }
}
