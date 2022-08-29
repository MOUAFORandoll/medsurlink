<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Antonrom\ModelChangesHistory\Traits\HasChangesHistory;

/**
 * App\Models\ConsultationExamenValidation
 *
 * @property int $id
 * @property int|null $souscripteur_id
 * @property int|null $examen_complementaire_id
 * @property int|null $medecin_id
 * @property int|null $medecin_control_id
 * @property int|null $ligne_de_temps_id
 * @property int|null $etat_validation_medecin
 * @property int|null $etat_validation_souscripteur
 * @property string|null $date_validation_medecin
 * @property string|null $date_validation_souscripteur
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $consultation_general_id
 * @property int|null $version
 * @property int|null $etablissement_id
 * @property-read \App\Models\ConsultationMedecineGenerale|null $consultation
 * @property-read \App\Models\EtablissementExercice|null $etablissement
 * @property-read \App\Models\ExamenComplementaire|null $examenComplementaire
 * @property-read \Illuminate\Database\Eloquent\Collection|\Antonrom\ModelChangesHistory\Models\Change[] $historyChangesMorph
 * @property-read int|null $history_changes_morph_count
 * @property-read \Antonrom\ModelChangesHistory\Models\Change|null $latestChangeMorph
 * @property-read \App\Models\LigneDeTemps|null $ligneDeTemps
 * @property-read \App\Models\Souscripteur|null $souscripteur
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereConsultationGeneralId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereDateValidationMedecin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereDateValidationSouscripteur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereEtatValidationMedecin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereEtatValidationSouscripteur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereExamenComplementaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereLigneDeTempsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereMedecinControlId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereMedecinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereSouscripteurId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereVersion($value)
 * @mixin \Eloquent
 */
class ConsultationExamenValidation extends Model
{
    use HasChangesHistory;
    protected $table = 'consultation_examen_validation';

    protected $fillable = [
        'souscripteur_id',
        'examen_complementaire_id',
        'medecin_id',
        'medecin_control_id',
        "etablissement_id",
        'ligne_de_temps_id',
        'etat_validation_medecin',
        'etat_validation_souscripteur',
        'date_validation_medecin',
        'date_validation_souscripteur',
        'consultation_general_id',
        'version'
    ];

    public function ligneDeTemps(){
        return $this->belongsTo(LigneDeTemps::class,'ligne_de_temps_id','id');
    }
    public function examenComplementaire(){
        return $this->belongsTo(ExamenComplementaire::class,'examen_complementaire_id','id');
    }
    public function etablissement(){
        return $this->belongsTo(EtablissementExercice::class,'etablissement_id','id');
    }
    public function consultation(){
        return $this->belongsTo(ConsultationMedecineGenerale::class,'consultation_general_id','id');
    }

    public function souscripteur(){
        return $this->belongsTo(Souscripteur::class,'souscripteur_id','user_id');
    }
}
