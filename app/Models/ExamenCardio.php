<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\ExamenCardio
 *
 * @property int $id
 * @property int $cardiologie_id
 * @property string $nom
 * @property string $date_examen
 * @property string $description
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Cardiologie $cardiologie
 * @property-read mixed $nom_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio newQuery()
 * @method static \Illuminate\Database\Query\Builder|ExamenCardio onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio whereCardiologieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio whereDateExamen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ExamenCardio withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ExamenCardio withoutTrashed()
 * @mixin \Eloquent
 */
class ExamenCardio extends Model
{
    use Sluggable;
    use SoftDeletes;

    protected $fillable = [
        "cardiologie_id",
        "nom",
        "date_examen",
        "description",
        "slug",
        "ligne_de_temps_id"
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'NomAndTimestamp'
            ]
        ];
    }

    public function getNomAndTimestampAttribute() {
        return $this->nom . ' ' .Carbon::now()->timestamp;
    }

    public function cardiologie(){
        return $this->belongsTo(Cardiologie::class,'cardiologie_id','id');
    }

    public function updateExamen(){
        $isAuthor = checkIfIsAuthorOrIsAuthorized("ExamenCardio",$this->id,"create");
        $canUpdate = checkIfCanUpdated("ExamenCardio",$this->id,"create");
        $this['isAuthor']=$isAuthor->getOriginalContent();
        $connectedUser = Auth::user();
        if ($connectedUser->getRoleNames()->first() == 'Praticien'){
            $this['canUpdate']=$canUpdate->getOriginalContent() && is_null($this->passed_at) && is_null($this->archieved_at);
        }elseif ($connectedUser->getRoleNames()->first() == 'Medecin controle'){
            if ($isAuthor->getOriginalContent() == true)
                $this['canUpdate'] = is_null($this->archieved_at);
            else{
                $this['canUpdate']=$canUpdate->getOriginalContent() && !is_null($this->passed_at) && is_null($this->archieved_at);
            }
        }elseif($connectedUser->getRoleNames()->first() == 'Admin'){
            $this['canUpdate']=true;
        }
    }
}
