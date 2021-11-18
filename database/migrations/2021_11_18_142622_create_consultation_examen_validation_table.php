<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultationExamenValidationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultation_examen_validation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('souscripteur_id');
            $table->unsignedBigInteger('examen_complementaire_id');
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
            $table->foreign('examen_complementaire_id')->references('id')->on('examen_complementaire')->onDelete('RESTRICT')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultation_examen_validation');
    }
}
