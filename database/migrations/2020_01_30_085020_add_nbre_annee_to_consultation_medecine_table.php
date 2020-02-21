<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNbreAnneeToConsultationMedecineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultation_medecine_generales', function (Blueprint $table) {
            $table->string('nbreAnnee')->default('0');
            $table->string('nbreCigarette')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consultation_medecine_generales', function (Blueprint $table) {
            //
        });
    }
}
