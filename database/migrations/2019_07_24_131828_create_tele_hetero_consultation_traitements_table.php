<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeleHeteroConsultationTraitementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tele_hetero_consult_traitement', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('consultation_id');
            $table->unsignedBigInteger('traitement_id');
            $table->date('date');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('consultation_id')
                ->references('id')
                ->on('tele_hetero_consultation')
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
        Schema::dropIfExists('tele_hetero_consult_traitement', function (Blueprint $table) {
            $table->dropForeign(['consultation_id', 'traitement_id']);
        });
    }
}
