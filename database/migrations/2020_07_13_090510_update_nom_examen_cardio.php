<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateNomExamenCardio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('examen_cardios', function (Blueprint $table) {
            DB::statement("ALTER TABLE examen_cardios MODIFY COLUMN nom ENUM('Épreuves d\'effort','Echographie trans-œsophagienne','Echographie trans-thoracique','RX Thorax','Echographie','MAPA','Holter','Tilt Test','Biologie') NULL ");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('examen_cardios', function (Blueprint $table) {
            //
        });
    }
}
