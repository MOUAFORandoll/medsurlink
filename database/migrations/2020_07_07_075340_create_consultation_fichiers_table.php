<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultationFichiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultation_fichiers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('dossier_medical_id');
            $table->unsignedBigInteger('etablissement_id');
            $table->unsignedBigInteger( "creator");
            $table->unsignedBigInteger('user_id');
            $table->date('passed_at')->nullable();
            $table->date('archieved_at')->nullable();
            $table->string('slug');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('dossier_medical_id')
                ->references('id')
                ->on('dossier_medicals')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('etablissement_id')
                ->references('id')
                ->on('etablissement_exercices')
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
        Schema::dropIfExists('consultation_fichiers');
    }
}
