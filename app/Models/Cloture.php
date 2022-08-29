<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Cloture
 *
 * @property int $id
 * @property int $cloturable_id
 * @property string $cloturable_type
 * @property string|null $automatique
 * @property string|null $ama
 * @property string|null $medecin_referent
 * @property string|null $gestionnaire
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Model|\Eloquent $cloturable
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture newQuery()
 * @method static \Illuminate\Database\Query\Builder|Cloture onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture whereAma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture whereAutomatique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture whereCloturableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture whereCloturableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture whereGestionnaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture whereMedecinReferent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Cloture withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Cloture withoutTrashed()
 * @mixin \Eloquent
 */
class Cloture extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'cloturable_id',
        'cloturable_type',
        'automatique',
        'ama',
        'medecin_referent',
        'gestionnaire'
    ];

    public function cloturable(){
        return $this->morphTo();
    }

}
