<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientMedecinControlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_medecin_controles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('medecin_control_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('creator')->nullable();
            $table->string('slug');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('medecin_control_id')
            ->references('user_id')
            ->on('medecin_controles')
            ->onDelete('RESTRICT')
            ->onUpdate('RESTRICT');

            $table->foreign('patient_id')
            ->references('user_id')
            ->on('patients')
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
        Schema::dropIfExists('patient_medecin_controles');
    }
}
