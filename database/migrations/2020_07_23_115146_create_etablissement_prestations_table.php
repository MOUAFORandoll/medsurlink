<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtablissementPrestationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etablissement_prestation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('etablissement_id');
            $table->unsignedBigInteger('prestation_id');
            $table->unsignedBigInteger('creator')->nullable();
            $table->string('prix');
            $table->string('reduction')->nullable();
            $table->string('slug');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('prestation_id')
                ->references('id')
                ->on('prestations')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('creator')
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
        Schema::dropIfExists('etablissement_prestation');
    }
}
