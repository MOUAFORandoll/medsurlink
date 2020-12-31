<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaiementToAffiliationSouscripteurs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('affiliation_souscripteurs', function (Blueprint $table) {
            $table->dateTime('date_paiement')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('affiliation_souscripteurs', function (Blueprint $table) {
            $table->dropColumn('date_paiement');
        });
    }
}
