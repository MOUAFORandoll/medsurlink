<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * App\Models\SuiviToDoList
 *
 * @property int $id
 * @property string|null $listable_type
 * @property int|null $listable_id
 * @property string|null $intitule
 * @property string|null $description
 * @property string|null $statut
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $type_and_timestamp
 * @property-read Model|\Eloquent $listable
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList newQuery()
 * @method static \Illuminate\Database\Query\Builder|SuiviToDoList onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList query()
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList whereIntitule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList whereListableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList whereListableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|SuiviToDoList withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SuiviToDoList withoutTrashed()
 * @mixin \Eloquent
 */
class SuiviToDoList extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
      "listable_type",
      "listable_id",
      "intitule",
      "description",
      "statut",
      "slug",
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'TypeAndTimestamp'
            ]
        ];
    }

    public function getTypeAndTimestampAttribute() {
        return Str::random(6) . ' ' . Carbon::now()->timestamp;
    }

    public function listable(){
        return $this->morphTo();
    }
}
