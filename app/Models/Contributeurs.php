<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Contributeurs
 *
 * @property int $id
 * @property string|null $contributable_type
 * @property int|null $contributable_id
 * @property string|null $operationable_type
 * @property int|null $operationable_id
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Model|\Eloquent $contributable
 * @property-read mixed $type_and_timestamp
 * @property-read Model|\Eloquent $operationable
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs newQuery()
 * @method static \Illuminate\Database\Query\Builder|Contributeurs onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs whereContributableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs whereContributableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs whereOperationableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs whereOperationableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Contributeurs withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Contributeurs withoutTrashed()
 * @mixin \Eloquent
 */
class Contributeurs extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
        "contributable_id",
        "contributable_type",
        "operationable_id",
        "operationable_type",
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
        return $this->contributable_type.' '.Carbon::now()->timestamp;
    }

    public function contributable(){
        return $this->morphTo()->withTrashed();
    }

    public function operationable(){
        return $this->morphTo()->withTrashed();
    }
}
