<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDossierMedicalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dossier_medicals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_id');
            $table->date('date_de_creation');
            $table->string('numero_dossier')->unique();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('patient_id')
                ->references('id')
                ->on('patients')
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
    Schema::dropIfExists('dossier_medicals', function (Blueprint $table) {
        $table->dropForeign('patient_id');
    });
}
}
