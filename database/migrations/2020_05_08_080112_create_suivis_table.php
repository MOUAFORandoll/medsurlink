<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuivisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suivis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dossier_medical_id');
            $table->unsignedBigInteger('responsable')->nullable();
            $table->unsignedBigInteger('creator')->nullable();
            $table->longText('motifs')->nullable();
            $table->string('slug')->unique();
            $table->string('etat')->nullable();
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('dossier_medical_id')
                ->references('id')
                ->on('dossier_medicals')
                ->onUpdate('restrict')
                ->onDelete('restrict');

            $table->foreign('responsable')
                ->references('id')
                ->on('users')
                ->onUpdate('restrict')
                ->onDelete('restrict');

            $table->foreign('creator')
                ->references('id')
                ->on('users')
                ->onUpdate('restrict')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suivis');
    }
}
