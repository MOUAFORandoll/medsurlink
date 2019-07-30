<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultPrenExamClinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consult_pren_exam_clin', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('consultation_prenatale_id');
            $table->unsignedBigInteger('examen_clinique_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('consultation_prenatale_id')
                ->references('id')
                ->on('consultation_prenatales')
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
        Schema::dropIfExists('consult_pren_exam_clin', function (Blueprint $table) {
            $table->dropForeign(['consultation_prenatale_id','examen_clinique_id']);
        });
    }
}
