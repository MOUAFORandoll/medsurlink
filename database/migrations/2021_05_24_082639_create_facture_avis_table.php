<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactureAvisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facture_avis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('avis_id');
            $table->unsignedBigInteger('dossier_medical_id');
            $table->unsignedBigInteger('association_id');
            $table->unsignedBigInteger('etablissement_id');
            $table->unsignedBigInteger('creator')->nullable();
            $table->string('slug');
            $table->softDeletes();
            $table->timestamps();

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

            $table->foreign('avis_id')
                ->references('id')
                ->on('avis')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('association_id')
                ->references('id')
                ->on('associations')
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
        Schema::dropIfExists('facture_avis');
    }
}
