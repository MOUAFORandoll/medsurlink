<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateNumeroOrdreToMedecinControlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medecin_controles', function (Blueprint $table) {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE medecin_controles MODIFY  numero_ordre VARCHAR(192)');

            \Illuminate\Support\Facades\DB::statement('ALTER TABLE `medecin_controles` CHANGE `numero_ordre` `numero_ordre` VARCHAR(192) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT \'0000\'');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medecin_controles', function (Blueprint $table) {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE medecin_controles MODIFY  numero_ordre VARCHAR(192)');

        });
    }
}
