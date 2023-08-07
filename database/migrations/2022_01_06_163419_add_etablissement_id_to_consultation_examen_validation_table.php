<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEtablissementIdToConsultationExamenValidationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultation_examen_validation', function (Blueprint $table) {
            $table->unsignedBigInteger('etablissement_id')->nullable();
            $table->foreign('etablissement_id')->references('id')->on('etablissement_exercices')->onDelete('RESTRICT')->onUpdate('RESTRICT');
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
            $table->foreign('etablissement_id')->references('id')->on('etablissement_exercices')->onDelete('RESTRICT')->onUpdate('RESTRICT');
        });
    }
}
