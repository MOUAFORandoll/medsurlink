<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPerimetreAbdoToParametreCommunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parametre_communs', function (Blueprint $table) {
            $table->string('perimetre_abdominal')->nullable();
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
            $table->dropColumn('perimetre_abdominal');
        });
    }
}
