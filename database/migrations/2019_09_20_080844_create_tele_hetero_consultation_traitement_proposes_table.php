<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeleHeteroConsultationTraitementProposesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tele_traitement_proposes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('consultation_id');
            $table->string('slug')->unique();
            $table->string('intitule');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('tele_traitement_proposes', function (Blueprint $table) {
            $table->foreign('consultation_id')
                ->references('id')
                ->on('tele_hetero_consultation')
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
        Schema::dropIfExists('tele_traitement_proposes');
    }
}
