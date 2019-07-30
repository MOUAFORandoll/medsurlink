<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHospitalisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitalisations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dossier_medical_id');
            $table->date('date_entree')->default(\Carbon\Carbon::today()->format('Y-m-d'));
            $table->date('date_sortie');
            $table->text('hitoire_clinique');
            $table->text('mode_de_vie')->nullable();
            $table->text('evolution')->nullable();
            $table->text('conclusion')->nullable();
            $table->text('avis')->nullable();
            $table->text('traitement_sortie')->nullable();
            $table->text('rendez_vous')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hospitalisations');
    }
}
