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
            $table->unsignedBigInteger('prescription_id');
            $table->double('dose');
            $table->string('formulation');
            $table->string('voieAdmin');
            $table->integer('nombre');
            $table->string('par');
            $table->string('slug')->unique();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('prescription_id')
                ->references('id')
                ->on('prescriptions')
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
        Schema::dropIfExists('posologies');
    }
}
