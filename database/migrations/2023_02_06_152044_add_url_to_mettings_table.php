<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUrlToMettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mettings', function (Blueprint $table) {
            $table->longText('url')->after('medecin_id')->nullable();
            $table->integer('statut')->after('medecin_id')->default(2);// 2 encours, 3 terminer
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mettings', function (Blueprint $table) {
            $table->dropColumn(['url']);
        });
    }
}
