<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToConsultationMedecineGenerales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultation_medecine_generales', function (Blueprint $table) {
            $table->json('examens');
            $table->json('diasgnostic');
            $table->json('nutrition');
            $table->json('lipide');
            $table->json('glucide');
            $table->json('anamneses');
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
