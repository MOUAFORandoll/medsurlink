<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConsultationGeneralIdToConsultationExamenValidationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultation_examen_validation', function (Blueprint $table) {
            $table->unsignedBigInteger('consultation_general_id')->nullable();
            $table->foreign('consultation_general_id')->references('id')->on('consultation_medecine_generales')->onDelete('RESTRICT')->onUpdate('RESTRICT');
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
            //
        });
    }
}
