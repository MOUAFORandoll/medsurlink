<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToActivitesControle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activites_controle', function (Blueprint $table) {
            $table->unsignedInteger('affiliation_id')->nullable();
            $table->unsignedInteger('ligne_temps_id')->nullable();
            $table->unsignedBigInteger('etablissement_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activites_controle', function (Blueprint $table) {
            $table->dropColumn('ligne_temps_id');
            $table->dropColumn('etablissement_id');
            $table->dropColumn('affiliation_id');
        });
    }
}
