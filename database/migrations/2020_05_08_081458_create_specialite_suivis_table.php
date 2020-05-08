<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialiteSuivisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialite_suivis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('suivi_id');
            $table->unsignedBigInteger('responsable')->nullable();
            $table->unsignedBigInteger('specialite_id');
            $table->longText('motifs')->nullable();
            $table->string('slug')->unique();
            $table->string('etat')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('suivi_id')
                ->references('id')
                ->on('suivis')
                ->onUpdate('restrict')
                ->onDelete('restrict');

            $table->foreign('specialite_id')
                ->references('id')
                ->on('specialites')
                ->onUpdate('restrict')
                ->onDelete('restrict');

            $table->foreign('responsable')
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
        Schema::dropIfExists('specialite_suivis');
    }
}
