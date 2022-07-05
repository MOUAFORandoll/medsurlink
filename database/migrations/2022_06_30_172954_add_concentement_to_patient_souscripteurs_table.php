<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConcentementToPatientSouscripteursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_souscripteurs', function (Blueprint $table) {
            $table->boolean('souscripteur_consentement')->nullable()->after('lien_de_parente');
            $table->boolean('patient_consentement')->nullable()->after('souscripteur_consentement');
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
            $table->dropColumn(['souscripteur_consentement', 'patient_consentement']);
        });
    }
}
