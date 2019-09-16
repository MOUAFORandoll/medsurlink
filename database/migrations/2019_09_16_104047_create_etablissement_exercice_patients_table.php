<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtablissementExercicePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etablissement_exercice_patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('etablissement_id');
            $table->unsignedBigInteger('patient_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('etablissement_id')
                ->references('id')
                ->on('etablissement_exercices')
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
        Schema::dropIfExists('etablissement_exercice_patients', function (Blueprint $table) {
            $table->drop(['etablissement_id','patient_id']);
        });
    }
}
