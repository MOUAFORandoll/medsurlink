<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptionValidationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescription_validation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('souscripteur_id');
            $table->unsignedBigInteger('traitement_propose');
            $table->unsignedBigInteger('medecin_id');
            $table->unsignedBigInteger('medecin_control_id');
            $table->unsignedBigInteger('motif_consultation_id');
            $table->boolean('etat_validation_medecin');
            $table->boolean('etat_validation_souscripteur');
            $table->date('date_validation_medecin');
            $table->date('date_validation_souscripteur');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('medecin_control_id')->references('user_id')->on('medecin_controles')->onDelete('RESTRICT')->onUpdate('RESTRICT');
            $table->foreign('medecin_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('souscripteur_id')->references('user_id')->on('souscripteurs')->onDelete('RESTRICT')->onUpdate('RESTRICT');
            $table->foreign('motif_consultation_id')->references('id')->on('motifs')->onDelete('RESTRICT')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescription_validation');
    }
}
