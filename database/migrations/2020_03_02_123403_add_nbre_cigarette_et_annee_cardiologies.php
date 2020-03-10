<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNbreCigaretteEtAnneeCardiologies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cardiologies', function (Blueprint $table) {
            $table->string('nbreAnnee')->default('0');
            $table->string('nbreCigarette')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cardiologies', function (Blueprint $table) {
            $table->dropColumn(['nbreAnnee','nbreCigarette']);
        });
    }
}
