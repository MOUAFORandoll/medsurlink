<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKinesitherapiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kinesitherapies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('etablissement_id');
            $table->unsignedBigInteger('creator')->nullable();
            $table->unsignedBigInteger('dossier_medical_id');
            $table->date('date_consultation')->nullable();
            $table->longText('motifs')->nullable();
            $table->longText('anamnese')->nullable();
            $table->longText('profession')->nullable();
            $table->longText('evaluation_globale')->nullable();
            $table->longText('impression_diagnostique')->nullable();
            $table->longText('examens_complementaires')->nullable();
            $table->longText('conduite_a_tenir')->nullable();
            $table->string('slug');
            $table->softDeletes();
            $table->timestamps();
            $table->addColumn('timestamp','archieved_at')->nullable();
            $table->addColumn('timestamp','passed_at')->nullable();

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

            $table->foreign('creator')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('kinesitherapies');
    }
}
