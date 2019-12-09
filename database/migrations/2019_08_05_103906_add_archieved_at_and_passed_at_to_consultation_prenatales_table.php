<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArchievedAtAndPassedAtToConsultationPrenatalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultation_prenatales', function (Blueprint $table) {
            $table->addColumn('timestamp','archieved_at')->nullable();
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
        Schema::table('consultation_prenatales', function (Blueprint $table) {
            $table->dropColumn(['archieved_at','passed_at']);
        });
    }
}
