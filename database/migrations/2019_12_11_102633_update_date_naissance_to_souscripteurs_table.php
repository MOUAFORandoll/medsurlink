<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDateNaissanceToSouscripteursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('souscripteurs', function (Blueprint $table) {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE souscripteurs MODIFY  date_de_naissance date ');
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
            //
        });
    }
}
