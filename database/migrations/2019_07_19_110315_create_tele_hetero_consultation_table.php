<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeleHeteroConsultationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tele_hetero_consultation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dossier_medical_id');
            $table->date('date_consultation')->nullable();
            $table->text('anamese')->nullable();
            $table->text('mode_de_vie')->nullable();
            $table->text('examen_clinique')->nullable();
            $table->text('examen_complementaire')->nullable();
            $table->json('examens');
            $table->json('diasgnostic');
            $table->json('nutrition');
            $table->json('lipide');
            $table->json('glucide');
            $table->json('anamneses');
            $table->json('anthropometrie');
            $table->string('information')->nullable();
            $table->timestamp('archieved_at')->nullable();
            $table->timestamp('passed_at')->nullable();
            $table->text('traitement_propose')->nullable();
            $table->text('profession')->nullable();
            $table->string('situation_familiale')->nullable();
            $table->string('nbre_enfant')->default('0');
            $table->string('tabac')->default('Non');
            $table->string('alcool')->default('Non');
            $table->string('nbreAnnee')->default('0');
            $table->string('nbreCigarette')->default('0');
            $table->text('autres')->nullable();
            $table->unsignedInteger('etablissement_id')->nullable();
            $table->unsignedBigInteger('creator')->nullable();
            $table->string('file')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->string('slug')->unique();

            $table->foreign('dossier_medical_id')
                ->references('id')
                ->on('dossier_medicals')
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
        Schema::dropIfExists('tele_hetero_consultation', function (Blueprint $table) {
            $table->dropForeign('dossier_medical_id');
        });
    }
}
