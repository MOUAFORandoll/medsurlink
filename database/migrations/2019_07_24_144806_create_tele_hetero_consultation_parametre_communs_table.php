<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeleHeteroConsultationParametreCommunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tele_parametre_communs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('consultation_id')->nullable();
            $table->double('poids')->nullable();
            $table->double('taille')->nullable();
            $table->double('bmi')->nullable();
            $table->integer('ta_systolique')->nullable();
            $table->integer('ta_diastolique')->nullable();
            $table->double('temperature')->nullable();
            $table->integer('frequence_cardiaque')->nullable();
            $table->integer('frequence_respiratoire')->nullable();
            $table->integer('sato2')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->string('slug')->unique();
            $table->nullableMorphs('communable');

            // $table->foreign('consultation_id')
            //     ->references('id')
            //     ->on('tele_hetero_consultation')
            //     ->onDelete('RESTRICT')
            //     ->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tele_parametre_communs', function (Blueprint $table) {
            $table->dropMorphs('communable');
        });
    }
}
