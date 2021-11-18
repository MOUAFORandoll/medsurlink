<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiagnosticValidationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnostic_validation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('medecin_id');
            $table->unsignedBigInteger('medecin_control_id');
            $table->boolean('etat_validation_medecin');
            $table->date('date_validation_medecin');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('medecin_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('medecin_control_id')->references('user_id')->on('medecin_controles')->onDelete('RESTRICT')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diagnostic_validation');
    }
}
