<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPraticienIdToResultatLabosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resultat_labos', function (Blueprint $table) {
            $table->unsignedBigInteger('praticien_id')->nullable();
            $table->foreign('praticien_id')->references('user_id')->on('praticiens')->onDelete('RESTRICT')->onUpdate('RESTRICT');
            $table->string('consultation_medecine_generale_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resultat_labos', function (Blueprint $table) {
            $table->drop(['praticien_id']);
        });
    }
}
