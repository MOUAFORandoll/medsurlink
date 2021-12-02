<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitesAmaPatientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activites_ama_patient', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('activite_ama_id')->nullable();
            $table->unsignedBigInteger('creator')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->string('statut')->nullable();
            $table->date('date_cloture')->nullable();
            $table->string('slug');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('creator')
                ->references('id')
                ->on('users')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('patient_id')
                ->references('user_id')
                ->on('patients')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('activite_ama_id')
                ->references('id')
                ->on('activites_ama')
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
        Schema::dropIfExists('activites_ama_patient');
    }
}
