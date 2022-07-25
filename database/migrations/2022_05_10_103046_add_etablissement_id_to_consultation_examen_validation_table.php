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
            $table->unsignedInteger('etablissement_id')->nullable();
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
            $table->dropColumn('etablissement_id');
        });
    }
}
