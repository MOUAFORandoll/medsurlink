<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRestrictionToPatientSouscripteursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_souscripteurs', function (Blueprint $table) {
            $table->boolean('restriction')->nullable()->after('patient_consentement');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_souscripteurs', function (Blueprint $table) {
            $table->dropColumn('restriction');
        });
    }
}
