<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreatorToConsultationMedecineGenerale extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultation_medecine_generales', function (Blueprint $table) {
            $table->unsignedBigInteger('creator')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consultation_medecine_generales', function (Blueprint $table) {
            $table->dropColumn('creator');
        });
    }
}
