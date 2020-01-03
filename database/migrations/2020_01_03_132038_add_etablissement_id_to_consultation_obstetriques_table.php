<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEtablissementIdToConsultationObstetriquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultation_obstetriques', function (Blueprint $table) {
            $table->unsignedInteger('etablissement_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consultation_obstetriques', function (Blueprint $table) {
            $table->dropColumn('etablissement_id');
        });
    }
}
