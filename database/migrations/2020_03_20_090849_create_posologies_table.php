<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosologiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posologies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('dose');
            $table->string('formulation');
            $table->string('voieAdmin');
            $table->integer('nombre');
            $table->string('par');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posologies');
    }
}