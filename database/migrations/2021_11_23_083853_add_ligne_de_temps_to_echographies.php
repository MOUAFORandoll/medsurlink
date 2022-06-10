<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLigneDeTempsToEchographies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('echographies', function (Blueprint $table) {
            $table->unsignedBigInteger('ligne_de_temps_id')->nullable();
            $table->foreign('ligne_de_temps_id')->references('id')->on('ligne_de_temps')->onDelete('RESTRICT')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('echographies', function (Blueprint $table) {
            $table->unsignedBigInteger('ligne_de_temps_id');
        });
    }
}
