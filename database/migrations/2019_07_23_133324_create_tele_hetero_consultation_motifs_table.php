<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeleHeteroConsultationMotifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tele_hetero_consultation_motif', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('consultation_id');
            $table->unsignedBigInteger('motif_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('consultation_id')
                ->references('id')
                ->on('tele_hetero_consultation')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('motif_id')
                ->references('id')
                ->on('motifs')
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
        Schema::dropIfExists('tele_hetero_consultation_motif', function (Blueprint $table) {
            $table->dropForeign(['consultation_id','motif_id']);
        });
    }
}
