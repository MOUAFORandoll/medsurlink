<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamenCardiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examen_cardios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cardiologie_id');
            $table->enum('nom',['ECG','RX Thorax','Echographie','MAPA','Holter','Tilt Test','Biologie']);
            $table->date('date_examen');
            $table->text('description');
            $table->string('slug')->unique();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('cardiologie_id')
                ->references('id')
                ->on('cardiologies')
                ->onDelete('Restrict')
                ->onUpdate('Restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('examen_cardios');
    }
}
