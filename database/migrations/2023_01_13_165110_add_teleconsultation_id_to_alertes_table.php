<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTeleconsultationIdToAlertesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alertes', function (Blueprint $table) {
            $table->bigInteger('teleconsultation_id')->after('niveau_urgence_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alertes', function (Blueprint $table) {
            $table->dropColumn(['teleconsultation_id']);
        });
    }
}
