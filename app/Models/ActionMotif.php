<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ActionMotif
 *
 * @property int $id
 * @property string $actionable_type
 * @property int $actionable_id
 * @property int $motif_id
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $actionable
 * @property-read mixed $action_and_timestamp
 * @property-read \App\Models\Motif $motifs
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMotif findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMotif newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMotif newQuery()
 * @method static \Illuminate\Database\Query\Builder|ActionMotif onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMotif query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMotif whereActionableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMotif whereActionableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMotif whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMotif whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMotif whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMotif whereMotifId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMotif whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMotif whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ActionMotif withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ActionMotif withoutTrashed()
 * @mixin \Eloquent
 */
class ActionMotif extends Model
{
    use Sluggable;
    use SoftDeletes;

    protected $fillable = [
        "actionable_type",
        "actionable_id",
        "slug",
        "motif_id",
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
                'source' => 'ActionAndTimestamp'
            ]
        ];
    }

    public function getActionAndTimestampAttribute()
    {
        return $this->actionable_type .''. Carbon::now()->timestamp;
    }

    public function actionable()
    {
        return $this->morphTo();
    }

    public function motifs(){
        return $this->belongsTo(Motif::class,'motif_id','id');
    }
}
