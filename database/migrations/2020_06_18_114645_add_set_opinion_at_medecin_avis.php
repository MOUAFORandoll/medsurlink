<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSetOpinionAtMedecinAvis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medecin_avis', function (Blueprint $table) {
            $table->dateTime('set_opinion_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medecin_avis', function (Blueprint $table) {
            $table->dropColumn('set_opinion_at');
        });
    }
}
