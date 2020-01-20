<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNiptToConsultationObstetriquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultation_obstetriques', function (Blueprint $table) {
            $table->string('t1')->default('nipt');
            $table->string('nle_anle')->default('Non');
            $table->string('sexe')->default('XX');
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
            $table->dropColumn(['nipt','bi_test','nle_anle','sexe']);
        });
    }
}
