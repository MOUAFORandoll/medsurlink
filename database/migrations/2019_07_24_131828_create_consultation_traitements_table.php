<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultationTraitementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consult_traitement', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('consultation_medecine_generale_id');
            $table->unsignedBigInteger('traitement_id');
            $table->date('date');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('consultation_medecine_generale_id')
                ->references('id')
                ->on('consultation_medecine_generales')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('traitement_id')
                ->references('id')
                ->on('traitements')
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
        Schema::dropIfExists('consult_traitement', function (Blueprint $table) {
            $table->dropForeign(['consultation_medecine_generale_id', 'traitement_id']);
        });
    }
}
