<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatutMotifToFacturesPrestations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facture_prestations', function (Blueprint $table) {
            $table->string('statut')->default('Généré');
            $table->string('motif')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facture_prestations', function (Blueprint $table) {
            $table->dropColumn('statut');
            $table->dropColumn('motif');
        });
    }
}
