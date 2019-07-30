<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultPrenExamComsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consult_pren_exam_com', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('consultation_prenatale_id');
            $table->unsignedBigInteger('examen_complementaire_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('consultation_prenatale_id')
                ->references('id')
                ->on('consultation_prenatales')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('examen_complementaire_id')
                ->references('id')
                ->on('examen_complementaires')
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
        Schema::dropIfExists('consult_pren_exam_com', function (Blueprint $table) {
            $table->dropForeign(['examen_complementaire_id','examen_clinique_id']);
        });
    }
}
