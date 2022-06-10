<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Antonrom\ModelChangesHistory\Traits\HasChangesHistory;
class Affiliation extends Model
{
    use SoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    use SlugRoutable;
    use HasChangesHistory;

    protected $fillable = [
        "patient_id",
        "souscripteur_id",
        "package_id",
        "paiement_id",
        "date_signature",
        "status_contrat",
        "status_paiement",
        "renouvelle",
        "expire",
        "code_contrat",
        "niveau_urgence",
        'plainte',
        'paye_par_affilie',
        'contact_firstName',
        'contact_name',
        'contact_phone',
        "nombre_envois_email",
        "expire_email",
        "nom",
        "date_debut",
        "date_fin",
        "selected", // par quelle canal avez vous entendu parler de medicasure pour la première fois ?
        'slug'
    ];

    protected $attributes = [
        'status_contrat' => 'Généré',
        'status_paiement' => "NON PAYE",
        'renouvelle' => 0,
        'expire' => 0
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
                'source' => 'NomAndTimestamp'
            ]
        ];
    }
    public function getNomAndTimestampAttribute() {
        return $this->nom . ' ' .Carbon::now()->timestamp;
    }

    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id','user_id');
    }

    public function souscripteur(){
        return $this->belongsTo(Souscripteur::class,'souscripteur_id','user_id');
    }

    public function package(){
        return $this->belongsTo(Package::class,'package_id','id');
    }

    public function ligneTemps(){
        return $this->hasMany(LigneDeTemps::class)->orderBy('updated_at', 'desc');
    }

    public function motifs(){
        return $this->morphToMany(Motif::class, 'motiffable');
    }

    public function cloture(){
        return $this->morphOne(Cloture::class, 'cloturable');
    }
}
