<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRendezVousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rendez_vouses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->nullableMorphs('sourceable');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('praticien_id')->nullable();
            $table->text('motifs')->nullable();
            $table->dateTime('date');
            $table->string('statut')->nullable();
            $table->string('slug')->unique();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('patient_id')
                ->references('user_id')
                ->on('patients')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('praticien_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('rendez_vouses');
    }
}
