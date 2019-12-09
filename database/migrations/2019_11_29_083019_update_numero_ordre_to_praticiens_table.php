<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateNumeroOrdreToPraticiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('praticiens', function (Blueprint $table) {
            DB::statement('ALTER TABLE praticiens MODIFY  numero_ordre VARCHAR(192)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('praticiens', function (Blueprint $table) {
            //
        });
    }
}
