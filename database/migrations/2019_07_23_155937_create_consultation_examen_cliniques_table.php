<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultationExamenCliniquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultation_clinique', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('consultation_medecine_generale_id');
            $table->unsignedBigInteger('examen_clinique_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('consultation_medecine_generale_id')
                ->references('id')
                ->on('consultation_medecine_generales')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('examen_clinique_id')
                ->references('id')
                ->on('examen_cliniques')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultation_clinique', function (Blueprint $table) {
            $table->dropForeign(['consultation_medecine_generale_id','examen_clinique_id']);
        });
    }
}
