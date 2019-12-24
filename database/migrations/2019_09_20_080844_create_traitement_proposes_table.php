<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraitementProposesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traitement_proposes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('consultation_medecine_generale_id');
            $table->string('slug')->unique();
            $table->string('intitule');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('traitement_proposes', function (Blueprint $table) {
            $table->foreign('consultation_medecine_generale_id')
                ->references('id')
                ->on('consultation_medecine_generales')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('traitement_proposes');
    }
}
