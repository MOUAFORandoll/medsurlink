<?php

namespace App\Models;

use Antonrom\ModelChangesHistory\Traits\HasChangesHistory;
use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 * App\Models\RendezVous
 *
 * @property int $id
 * @property string|null $sourceable_type
 * @property int|null $sourceable_id
 * @property int $patient_id
 * @property int|null $praticien_id
 * @property User $initiateur
 * @property string|null $motifs
 * @property string $date
 * @property string|null $statut
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $nom_medecin
 * @property int|null $creator
 * @property int|null $consultation_id
 * @property int|null $etablissement_id
 * @property int|null $ligne_temps_id
 * @property-read \App\Models\ConsultationMedecineGenerale|null $consultationsMedecine
 * @property-read \App\Models\EtablissementExercice|null $etablissement
 * @property-read mixed $name_and_timestamp
 * @property-read \App\Models\LigneDeTemps|null $ligne_temps
 * @property-read User $patient
 * @property-read User|null $praticien
 * @property-read Model|\Eloquent $sourceable
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous newQuery()
 * @method static \Illuminate\Database\Query\Builder|RendezVous onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous query()
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereInitiateur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereLigneTempsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereMotifs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereNomMedecin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous wherePraticienId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereSourceableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereSourceableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|RendezVous withTrashed()
 * @method static \Illuminate\Database\Query\Builder|RendezVous withoutTrashed()
 * @mixin \Eloquent
 */
class RendezVous extends Model
{
    use SoftDeletes;
    use Sluggable;
    use Notifiable;
    use SluggableScopeHelpers;
    use HasChangesHistory;

    protected $table='rendez_vous';

    protected $fillable = [
        "sourceable_id",
        "sourceable_type",
        "patient_id",
        "praticien_id",
        "initiateur",
        "motifs",
        "date",
        "statut",
        "slug",
        "nom_medecin",
        "ligne_temps_id",
        "consultation_id",
        'etablissement_id',
        'parent_id'
    ];

    protected $hidden = ['initiateur','updated_at'];

    protected $slackChannels= [
        'appel' => 'https://hooks.slack.com/services/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',
        'test' => 'https://hooks.slack.com/services/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'
    ];

    protected $slack_url = null;
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

    public function scopeJours306090($query, $date_debut, $date_fin)
    {
        return $query->where(function ($query) use($date_debut, $date_fin) {
            $query->where('statut', "Manqué")->whereDate('date', '>=', $date_debut)->whereDate('date', '<', $date_fin);
        })->orderBy('date', 'desc');
    }

    public function scopeEffectues306090($query, $date_debut, $date_fin)
    {
        return $query->where(function ($query) use($date_debut, $date_fin) {
            $query->where('statut', "Effectué")->whereDate('date', '>=', $date_debut)->whereDate('date', '<', $date_fin);
        })->orderBy('date', 'desc');
    }

    public function scopeFiltre($query, $date_debut, $date_fin, $statut)
    {
        return $query->where(function ($query) use($date_debut, $date_fin, $statut) {
            $query->where('statut', "statut")->whereDate('date', '>=', $date_debut)->whereDate('date', '<', $date_fin);
        })->orderBy('date', 'desc');
    }

    public function scopeRdvSemaineMoisAnnee($query, $intervalle_debut, $intervalle_fin)
    {
        return $query->where(function ($query) use($intervalle_debut, $intervalle_fin) {
            $query->whereDate('created_at', '>=', $intervalle_debut)->whereDate('created_at', '<=', $intervalle_fin);
        })->orderBy('created_at', 'asc');
    }

    public function getNameAndTimestampAttribute() {
        return Str::random(16).' '.Carbon::now()->timestamp;
    }

    public function patient(){
        return $this->belongsTo(User::class,'patient_id','id');
    }

    public function praticien(){
        return $this->belongsTo(User::class,'praticien_id','id');
    }

    public function initiateur(){
        return $this->belongsTo(User::class,'initiateur','id');
    }

    public function ligne_temps(){
        return $this->belongsTo(LigneDeTemps::class, 'ligne_temps_id', 'id');
    }

    public function etablissement(){
        return $this->belongsTo(EtablissementExercice::class, 'etablissement_id', 'id');
    }

    public function consultationsMedecine(){
        return $this->belongsTo(ConsultationMedecineGenerale::class, 'consultation_id', 'id');
    }


    public function sourceable(){
        return $this->morphTo();
    }

    public function updateRendezVous(){
        if(!is_null($this)){
            $rdv = $this;
            $user =  $rdv->patient;
            $patient = $user->patient;
            if (!is_null($patient)){
                $dossier = $patient->dossier;
                unset($this->patient['patient']);
                $this->patient['dossier_medical'] =$dossier;
            }
        }
    }

    public function routeNotificationForSlack(){
        if($this->slack_url === null){
            return $this->slackChannels['appel'];
        }
        return $this->slack_url;
    }
    /**
     * @param $name
     * @return $this
     */
    public function setSlackChannel($name){
        if(isset($this->slackChannels[$name])){
            $this->setSlackUrl($this->slackChannels[$name]);
        }

        return $this;
    }

    /**
     * @param $url
     * @return $this
     */
    public function setSlackUrl($url){
        $this->slack_url = $url;

        return $this;
    }
}
