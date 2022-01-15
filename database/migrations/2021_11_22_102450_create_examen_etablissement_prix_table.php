<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamenEtablissementPrixTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examen_etablissement_prix', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('etablissement_exercices_id');
            $table->unsignedBigInteger('examen_complementaire_id')->nullable();
            $table->unsignedBigInteger('other_complementaire_id')->nullable();
            $table->bigInteger('prix');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('etablissement_exercices_id')->references('id')->on('etablissement_exercices')->onDelete('RESTRICT')->onUpdate('RESTRICT');
            $table->foreign('examen_complementaire_id')->references('id')->on('examen_complementaire')->onDelete('RESTRICT')->onUpdate('RESTRICT');
            $table->foreign('other_complementaire_id')->references('id')->on('other_complementaire')->onDelete('RESTRICT')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('examen_etablissement_prix');
    }
}
