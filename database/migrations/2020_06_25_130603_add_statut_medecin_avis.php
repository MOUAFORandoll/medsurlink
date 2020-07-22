<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatutMedecinAvis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medecin_avis', function (Blueprint $table) {
            $table->string('statut')->nullable()->default('NON VALIDE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medecin_avis', function (Blueprint $table) {
            $table->dropColumn('statut');
        });
    }
}
