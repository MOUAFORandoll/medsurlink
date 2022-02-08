<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVersionValidationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('version_validations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('version');
            $table->float('montant_prestation');
            $table->float('montant_medecin');
            $table->float('montant_souscripteur');
            $table->float('montant_total');
            $table->float('plus_value');
            $table->unsignedBigInteger('consultation_general_id')->nullable();
            $table->foreign('consultation_general_id')->references('id')->on('consultation_medecine_generales')->onDelete('RESTRICT')->onUpdate('RESTRICT');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('version_validations');
    }
}
