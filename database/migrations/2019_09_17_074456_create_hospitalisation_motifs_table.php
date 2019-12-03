<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHospitalisationMotifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitalisation_motif', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('hospitalisation_id');
            $table->unsignedBigInteger('motif_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('hospitalisation_id')
                ->references('id')
                ->on('hospitalisations')
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
        Schema::dropIfExists('hospitalisation_motif', function (Blueprint $table) {
            $table->dropForeign(['hospitalisation_id','motif_id']);
        });
    }
}
