<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateModeDeVieToConsultationMedecineGeneralesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultation_medecine_generales', function (Blueprint $table) {
            $table->text('profession')->nullable()->change();
            $table->string('situation_familiale')->nullable()->change();
            $table->string('nbre_enfant')->default('0')->change();
            $table->string('tabac')->default('Non')->change();
            $table->string('alcool')->default('Non')->change();
            $table->text('autres')->nullable()->change();
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
            //
        });
    }
}
