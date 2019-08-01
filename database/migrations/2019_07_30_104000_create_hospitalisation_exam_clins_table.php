<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHospitalisationExamClinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitalisation_exam_clin', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('hospitalisation_id');
            $table->unsignedBigInteger('examen_clinique_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('examen_clinique_id')
                ->references('id')
                ->on('examen_cliniques')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('hospitalisation_id')
                ->references('id')
                ->on('hospitalisations')
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
        Schema::dropIfExists('hospitalisation_exam_clin', function (Blueprint $table) {
            $table->dropForeign(['hospitalisation_id','examen_clinique_id']);
        });
    }
}
