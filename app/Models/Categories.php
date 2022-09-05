<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * App\Models\Categories
 *
 * @property int $id
 * @property string|null $nom
 * @property string|null $icon
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $name_and_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Suivi[] $suivis
 * @property-read int|null $suivis_count
 * @method static \Illuminate\Database\Eloquent\Builder|Categories findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Categories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categories newQuery()
 * @method static \Illuminate\Database\Query\Builder|Categories onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Categories query()
 * @method static \Illuminate\Database\Eloquent\Builder|Categories whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categories whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categories whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categories whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categories whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categories whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Categories withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Categories withoutTrashed()
 * @mixin \Eloquent
 */
class Categories extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = ['nom','icon','slug'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'NameAndTimestamp'
            ]
        ];
    }

    public function getNameAndTimestampAttribute() {
        return Str::random(5).' '.Carbon::now()->timestamp;
    }

    public function suivis(){
        return $this->hasMany(Suivi::class,'categorie_id','id');
    }
}
