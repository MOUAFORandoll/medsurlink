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
            $table->date('date_entree')->default(\Carbon\Carbon::now()->format('Y-m-d'));
            $table->date('date_sortie')->nullable();
            $table->text('histoire_clinique');
            $table->text('mode_de_vie')->nullable();
            $table->text('evolution')->nullable();
            $table->text('conclusion')->nullable();
            $table->text('avis')->nullable();
            $table->text('traitement_sortie')->nullable();
            $table->text('rendez_vous')->nullable();
            $table->text('examen_clinique')->nullable();
            $table->text('examen_complementaire')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->string('slug')->unique();

            $table->foreign('dossier_medical_id')
                ->references('id')
                ->on('dossier_medicals')
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
        Schema::dropIfExists('hospitalisations', function (Blueprint $table) {
            $table->dropForeign('dossier_medical_id');
        });
    }
}
