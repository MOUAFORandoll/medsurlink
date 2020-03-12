<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetNullableDateDeNaissanceSouscripteurs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('souscripteurs', function (Blueprint $table) {
            $table->date('date_de_naissance')->nullable()->change();
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
            $table->date('date_de_naissance')->change();
        });
    }
}
