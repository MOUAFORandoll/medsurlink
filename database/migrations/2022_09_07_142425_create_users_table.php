<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metriques', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('temps_moyen');
            $table->double('affiliation_et_affectation_medecin_referents');
            $table->double('consultation_medecine_generale');
            $table->double('consultation_fichier');
            $table->double('resultat_labo');
            $table->double('resultat_imagerie');
            $table->double('avis_medicals');
            $table->double('medecin_controle');
            $table->double('consultation_examen_validation');
            $table->double('activite_amas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metriques');
    }
}
