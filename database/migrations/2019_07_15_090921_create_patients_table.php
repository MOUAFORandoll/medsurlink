<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('souscripteur_id')->nullable();
            $table->string('nom');
            $table->enum('sexe',['M','F']);
            $table->date('date_de_naissance');
            $table->integer('age')->nullable();
            $table->string('nationalite');
            $table->string('ville');
            $table->string('pays');
            $table->string('telephone');
            $table->string('email');
            $table->string('prenom')->nullable();
            $table->string('quartier')->nullable();
            $table->integer('code_postal')->nullable();
            $table->string('nom_contact')->nullable();
            $table->string('tel_contact')->nullable();
            $table->string('lien_contact')->nullable();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('souscripteur_id')
                ->references('id')
                ->on('souscripteurs')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

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
        Schema::dropIfExists('patients', function (Blueprint $table) {
            $table->dropForeign(['user_id','souscripteur_id']);
        });
    }
}
