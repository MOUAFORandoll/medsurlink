<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardiologiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cardiologies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('etablissement_id');
            $table->unsignedBigInteger('dossier_medical_id');
            $table->date('date_consultation')->nullable();
            $table->text('anamnese')->nullable();
            $table->string('facteur_de_risque')->nullable();
            $table->text('profession')->nullable();
            $table->string('situation_familiale')->nullable();
            $table->string('nbre_enfant')->default('0');
            $table->string('tabac')->default('Non');
            $table->string('alcool')->default('Non');
            $table->text('autres')->nullable();
            $table->text('conclusion')->nullable();
            $table->text('conduite_a_tenir')->nullable();
            $table->text('examen_clinique')->nullable();
            $table->date('rendez_vous')->nullable();
            $table->date('archieved_at')->nullable();
            $table->date('passed_at')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('dossier_medical_id')
                ->references('id')
                ->on('dossier_medicals')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('etablissement_id')
                ->references('id')
                ->on('etablissement_exercices')
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
        Schema::dropIfExists('cardiologies');
    }
}
