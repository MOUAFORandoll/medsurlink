<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTaDiastoliqueSystoliqueToParametreCommuns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parametre_communs', function (Blueprint $table) {
            $table->integer('ta_systolique_d')->nullable();
            $table->integer('ta_diastolique_d')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parametre_communs', function (Blueprint $table) {
            $table->dropColumn('ta_systolique_d','ta_diastolique_d');
        });
    }
}
