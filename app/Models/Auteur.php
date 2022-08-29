<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Auteur
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $auteurable_type
 * @property int|null $auteurable_id
 * @property string|null $operationable_type
 * @property int|null $operationable_id
 * @property string $action
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $patient_id
 * @property-read Model|\Eloquent $auteurable
 * @property-read Model|\Eloquent $operationable
 * @property-read User|null $patient
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur newQuery()
 * @method static \Illuminate\Database\Query\Builder|Auteur onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur query()
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereAuteurableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereAuteurableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereOperationableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereOperationableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Auteur withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Auteur withoutTrashed()
 * @mixin \Eloquent
 */
class Auteur extends Model
{
    use SoftDeletes;

    protected $fillable =[
        "auteurable_type",
        "auteurable_id",
        "operationable_type",
        "operationable_id",
        "action",
        "user_id",
        "patient_id",
    ];

    /**
     * Get the owning auteurable model.
     */
    public function auteurable()
    {
        return $this->morphTo();
    }
    /**
     * Get the owning operationable model.
     */
    public function operationable()
    {
        return $this->morphTo();
    }

    public function patient(){
        return $this->belongsTo(User::class,'patient_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
