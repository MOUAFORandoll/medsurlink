<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompteRenduOperatoiresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compte_rendu_operatoires', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('etablissement_id');
            $table->unsignedBigInteger('dossier_medical_id');
            $table->unsignedBigInteger('creator')->nullable();
            $table->longText('type_intervention')->nullable();
            $table->longText('histoire_clinique')->nullable();
            $table->dateTime('date_intervention')->nullable();
            $table->longText('chirugiens')->nullable();
            $table->longText('aides')->nullable();
            $table->longText('circulants')->nullable();
            $table->longText('anesthesistes')->nullable();
            $table->longText('type_anesthesie')->nullable();
            $table->longText('description')->nullable();
            $table->longText('traitement_post_operatoire')->nullable();
            $table->addColumn('timestamp','archieved_at')->nullable();
            $table->addColumn('timestamp','passed_at')->nullable();
            $table->string('slug');
            $table->softDeletes();
            $table->timestamps();

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

            $table->foreign('creator')
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
        Schema::dropIfExists('compte_rendu_operatoires');
    }
}
