<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('conduite_a_tenir');
            $table->unsignedBigInteger('medecin_id');
            $table->unsignedBigInteger('medecin_control_id');
            $table->unsignedBigInteger('motif_consultation_id');
            $table->boolean('etat_validation_medecin');
            $table->date('date_validation_medecin');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('medecin_control_id')->references('user_id')->on('medecin_controles')->onDelete('RESTRICT')->onUpdate('RESTRICT');
            $table->foreign('medecin_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('motif_consultation_id')->references('id')->on('motifs')->onDelete('RESTRICT')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat');
    }
}
