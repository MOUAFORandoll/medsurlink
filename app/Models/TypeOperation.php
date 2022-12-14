<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\TypeOperation
 *
 * @property int $id
 * @property string $libelle
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DelaiOperation[] $delai_operations
 * @property-read int|null $delai_operations_count
 * @property-read mixed $type_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOperation findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOperation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOperation newQuery()
 * @method static \Illuminate\Database\Query\Builder|TypeOperation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOperation query()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOperation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOperation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOperation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOperation whereLibelle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOperation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|TypeOperation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TypeOperation withoutTrashed()
 * @mixin \Eloquent
 */
class TypeOperation extends Model
{
    use Sluggable;
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'type_operations';



    protected $fillable = [
        "libelle",
        "slug",
    ];

    public function getTypeAndTimestampAttribute() {
        return $this->libelle.' '.Carbon::now()->timestamp;
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'TypeAndTimestamp'
            ]
        ];
    }

    public function delai_operations(){
        return $this->hasMany(DelaiOperation::class);
    }


}
