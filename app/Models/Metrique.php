<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class Metrique extends Model
{
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
  
    protected $fillable = [
        "temps_moyen",
        "affiliation_et_affectation_medecin_referents",
        "consultation_medecine_generale",
        "consultation_fichier",
        "resultat_labo",
        "resultat_imagerie",
        "avis_medicals",
        "medecin_controle",
        "consultation_examen_validation",
        "activite_amas",
        "date_recuperation",
        "nbre_patients"
    ];

}
