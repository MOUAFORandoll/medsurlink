<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametreCommunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametre_communs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('consultation_medecine_generale_id');
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

            $table->foreign('consultation_medecine_generale_id')
                ->references('id')
                ->on('consultation_medecine_generales')
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
        Schema::dropIfExists('parametre_communs', function (Blueprint $table) {
            $table->dropForeign(['consultation_medecine_generale_id']);
        });
    }
}
