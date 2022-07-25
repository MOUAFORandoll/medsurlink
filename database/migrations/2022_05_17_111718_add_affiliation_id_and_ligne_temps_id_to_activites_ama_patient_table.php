<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAffiliationIdAndLigneTempsIdToActivitesAmaPatientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activites_ama_patient', function (Blueprint $table) {
            $table->unsignedInteger('affiliation_id')->nullable();
            $table->unsignedInteger('ligne_temps_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activites_ama_patient', function (Blueprint $table) {
            $table->dropColumn(['affiliation_id', 'ligne_temps_id']);
        });
    }
}
