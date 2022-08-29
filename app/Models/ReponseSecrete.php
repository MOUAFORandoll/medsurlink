<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ReponseSecrete
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $question_id
 * @property string|null $reponse
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $type_and_timestamp
 * @property-read \App\Models\Question|null $question
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ReponseSecrete findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ReponseSecrete newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReponseSecrete newQuery()
 * @method static \Illuminate\Database\Query\Builder|ReponseSecrete onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ReponseSecrete query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReponseSecrete whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReponseSecrete whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReponseSecrete whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReponseSecrete whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReponseSecrete whereReponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReponseSecrete whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReponseSecrete whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReponseSecrete whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|ReponseSecrete withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ReponseSecrete withoutTrashed()
 * @mixin \Eloquent
 */
class ReponseSecrete extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
        'user_id',
        'question_id',
        'reponse',
        'slug',
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
                'source' => 'TypeAndTimestamp'
            ]
        ];
    }

    public function getTypeAndTimestampAttribute() {
        return substr($this->reponse,0,2) . ' ' . Carbon::now()->timestamp;
    }

    public function question(){
        return $this->belongsTo(Question::class,'question_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

}
