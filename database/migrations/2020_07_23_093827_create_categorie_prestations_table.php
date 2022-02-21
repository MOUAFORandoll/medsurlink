<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriePrestationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorie_prestations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom');
            $table->string('slug');
            $table->unsignedBigInteger('creator')->nullable();
            $table->softDeletes();
            $table->timestamps();


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
        Schema::dropIfExists('categorie_prestations');
    }
}
