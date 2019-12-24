<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use App\Scopes\RestrictEtablissementScope;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Netpok\Database\Support\RestrictSoftDeletes;

class EtablissementExercice extends Model
{
    use SoftDeletes;
    use RestrictSoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    use SlugRoutable;
    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = ['praticiens'];

    protected $fillable = [
        "name",
        "description",
        'slug',
        'logo'

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
                'source' => 'NameAndTimestamp'
            ]
        ];
    }
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new RestrictEtablissementScope);
    }
    public function getNameAndTimestampAttribute() {
        return $this->name. ' ' .Carbon::now()->timestamp;
    }

    public function praticiens(){
        return $this->belongsToMany(Praticien::class,'etablissement_exercice_praticien','etablissement_id','praticien_id');
    }

    public function patients(){
        return $this->belongsToMany(Patient::class,'etablissement_exercice_patient','etablissement_id','patient_id');
    }
}
