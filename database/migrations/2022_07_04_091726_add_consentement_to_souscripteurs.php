<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConsentementToSouscripteurs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('souscripteurs', function (Blueprint $table) {
            $table->boolean('consentement')->default(true)->after('age');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('souscripteurs', function (Blueprint $table) {
            $table->dropColumn('consentement');
        });
    }
}
