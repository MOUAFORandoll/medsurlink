<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dossier_medical_id');
            $table->unsignedBigInteger('consultation_medecine_generale_id');
            $table->enum('type',['Laboratoire','Imagerie']);
            $table->text('description');
            $table->date('date');
            $table->string('file')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('slug')->unique();

            $table->foreign('dossier_medical_id')
                ->references('id')
                ->on('dossier_medicals')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

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
        Schema::dropIfExists('resultats', function (Blueprint $table) {
            $table->dropForeign(['dossier_medical_id','']);
        });
    }
}
