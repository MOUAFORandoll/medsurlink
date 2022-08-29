<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Antonrom\ModelChangesHistory\Traits\HasChangesHistory;
/**
 * App\Models\VersionValidation
 *
 * @property int $id
 * @property int $version
 * @property float $montant_prestation
 * @property float $montant_medecin
 * @property float $montant_souscripteur
 * @property float $montant_total
 * @property float $plus_value
 * @property int|null $consultation_general_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $ligne_de_temps_id
 * @property-read \App\Models\ConsultationMedecineGenerale|null $consultation
 * @property-read \Illuminate\Database\Eloquent\Collection|\Antonrom\ModelChangesHistory\Models\Change[] $historyChangesMorph
 * @property-read int|null $history_changes_morph_count
 * @property-read \Antonrom\ModelChangesHistory\Models\Change|null $latestChangeMorph
 * @property-read \App\Models\LigneDeTemps|null $ligneDeTemps
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation query()
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation whereConsultationGeneralId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation whereLigneDeTempsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation whereMontantMedecin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation whereMontantPrestation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation whereMontantSouscripteur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation whereMontantTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation wherePlusValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation whereVersion($value)
 * @mixin \Eloquent
 */
class VersionValidation extends Model
{
    use HasChangesHistory;

    protected $table = 'version_validations';

    protected $fillable = [
        'montant_prestation',
        'montant_medecin',
        'montant_souscripteur',
        'montant_total',
        'plus_value',
        'consultation_general_id',
        'ligne_de_temps_id',
        'version'
    ];

    public function consultation(){
        return $this->belongsTo(ConsultationMedecineGenerale::class,'consultation_general_id','id');
    }

    public function ligneDeTemps(){
        return $this->belongsTo(LigneDeTemps::class,'ligne_de_temps_id','id');
    }
}
