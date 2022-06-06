<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLigneDeTempsIdToVersionValidationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('version_validations', function (Blueprint $table) {
            $table->unsignedInteger('ligne_de_temps_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('version_validations', function (Blueprint $table) {
            $table->dropColumn(['ligne_de_temps_id']);
        });
    }
}
