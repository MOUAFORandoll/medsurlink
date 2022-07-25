<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDateValidationsToConsultationExamenValidation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultation_examen_validation', function (Blueprint $table) {
            $table->dateTime('date_validation_medecin')->change();
            $table->dateTime('date_validation_souscripteur')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consultation_examen_validation', function (Blueprint $table) {
            $table->dateTime('date_validation_medecin')->change();
            $table->dateTime('date_validation_souscripteur')->change();
        });
    }
}
