<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitesControleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activites_controle', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('creator')->nullable();
            $table->string('statut')->nullable();
            $table->unsignedBigInteger('activite_id')->nullable();
            $table->longText('commentaire')->nullable();
            $table->date('date_cloture')->nullable();
            $table->string('slug');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('creator')
                ->references('id')
                ->on('users')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('activite_id')
                ->references('id')
                ->on('activites_medecin_referent')
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
        Schema::dropIfExists('activites_controle');
    }
}
