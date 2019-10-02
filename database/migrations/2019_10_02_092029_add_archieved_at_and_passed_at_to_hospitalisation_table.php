<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArchievedAtAndPassedAtToHospitalisationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hospitalisations', function (Blueprint $table) {
            $table->addColumn('timestamp','archived_at')->nullable();
            $table->addColumn('timestamp','passed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hospitalisations', function (Blueprint $table) {
            $table->dropColumn(['archived_at','passed_at']);
        });
    }
}
