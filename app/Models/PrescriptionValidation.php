<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PrescriptionValidation
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PrescriptionValidation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PrescriptionValidation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PrescriptionValidation query()
 * @mixin \Eloquent
 */
class PrescriptionValidation extends Model
{
    protected $table = 'prescription_validation';

    protected $fillable = [
        'souscripteur_id',
        'traitement_propose',
        'medecin_id',
        'medecin_control_id',
        'etat_validation_medecin',
        'etat_validation_medecin',
        'date_validation_medecin',
        'date_validation_souscripteur',
        "ligne_de_temps_id"
    ];
}
