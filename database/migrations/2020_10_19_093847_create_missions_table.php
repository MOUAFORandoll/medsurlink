<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('activites', function (Blueprint $table) {
//            $table->bigIncrements('id');
//            $table->unsignedBigInteger('dossier_medical_id')->nullable();
//            $table->unsignedBigInteger('creator')->nullable();
//            $table->longText('nom_activite')->nullable();
//            $table->longText('groupe_activite')->nullable();
//            $table->longText('nom_partenaire')->nullable();
//            $table->longText('description')->nullable();
//            $table->longText('statut')->nullable();
//            $table->longText('commentaires')->nullable();
//            $table->date('date');
//            $table->string('slug');
//            $table->softDeletes();
//            $table->timestamps();
//
//            $table->foreign('dossier_medical_id')
//                ->references('id')
//                ->on('dossier_medicals')
//                ->onDelete('RESTRICT')
//                ->onUpdate('RESTRICT');
//
//            $table->foreign('creator')
//                ->references('id')
//                ->on('users')
//                ->onDelete('RESTRICT')
//                ->onUpdate('RESTRICT');
//
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activites');
    }
}
