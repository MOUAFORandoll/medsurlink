<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActiviteMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activite_missions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('activite_id')->nullable();
            $table->unsignedBigInteger('dossier_medical_id')->nullable();
            $table->unsignedBigInteger('creator')->nullable();
            $table->unsignedBigInteger('description')->nullable();
            $table->longText('commentaire')->nullable();
            $table->text('nom_partenaire')->nullable();
            $table->text('nom_activite')->nullable();
            $table->text('slug')->nullable();
            $table->text('statut')->nullable();
            $table->date('date_cloture')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('dossier_medical_id')
                ->references('id')
                ->on('dossier_medicals')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('creator')
                ->references('id')
                ->on('users')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('activite_id')
                ->references('id')
                ->on('activites')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('description')
                ->references('id')
                ->on('groupe_activite_missions')
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
        Schema::dropIfExists('activite_missions');
    }
}
