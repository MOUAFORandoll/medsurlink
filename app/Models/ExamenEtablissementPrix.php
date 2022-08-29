<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ExamenEtablissementPrix
 *
 * @property int $id
 * @property int $etablissement_exercices_id
 * @property int|null $examen_complementaire_id
 * @property int|null $other_complementaire_id
 * @property int $prix
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\EtablissementExercice $etablissement
 * @property-read \App\Models\ExamenComplementaire|null $examenComplementaire
 * @property-read \App\Models\OtherComplementaire|null $otherExamenComplementaire
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenEtablissementPrix newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenEtablissementPrix newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenEtablissementPrix query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenEtablissementPrix whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenEtablissementPrix whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenEtablissementPrix whereEtablissementExercicesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenEtablissementPrix whereExamenComplementaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenEtablissementPrix whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenEtablissementPrix whereOtherComplementaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenEtablissementPrix wherePrix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenEtablissementPrix whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ExamenEtablissementPrix extends Model
{
    protected $table = 'examen_etablissement_prix';

    protected $fillable = [
        'etablissement_exercices_id',
        'examen_complementaire_id',
        'other_complementaire_id',
        'prix',
        'ligne_de_temps_id'
    ];
    public function etablissement(){
        return $this->belongsTo(EtablissementExercice::class,'etablissement_exercices_id','id');
    }
    public function examenComplementaire(){
        return $this->belongsTo(ExamenComplementaire::class,'examen_complementaire_id','id');
    }
    public function otherExamenComplementaire(){
        return $this->belongsTo(OtherComplementaire::class,'other_complementaire_id','id');
    }
}
