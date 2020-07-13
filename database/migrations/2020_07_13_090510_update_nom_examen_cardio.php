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
            DB::statement("ALTER TABLE `examen_cardios` CHANGE `nom` `nom` ENUM('ECG','Épreuves d\'effort','Echographie trans-œsophagienne','Echographie trans-thoracique','RX Thorax','Echographie','MAPA','Holter','Tilt Test','Biologie') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL");
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
            DB::statement("ALTER TABLE `examen_cardios` CHANGE `nom` `nom` ENUM('ECG','RX Thorax','Echographie','MAPA','Holter','Tilt Test','Biologie','Echographie trans-œsophagienne') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL");

        });
    }
}
