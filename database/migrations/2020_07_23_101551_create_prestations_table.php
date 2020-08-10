<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrestationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom');
            $table->string('prix')->nullable();
            $table->string('slug');
            $table->unsignedBigInteger('creator')->nullable();
            $table->unsignedBigInteger('categorie_id')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('creator')
                ->references('id')
                ->on('users')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('categorie_id')
                ->references('id')
                ->on('categorie_prestations')
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
        Schema::dropIfExists('prestations');
    }
}
