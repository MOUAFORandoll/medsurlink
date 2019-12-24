<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSouscripteursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('souscripteurs', function (Blueprint $table) {
//            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('sexe',['M','F']);
            $table->date('date_de_naissance');
            $table->integer('age')->nullable();
            $table->timestamps();
            $table->string('slug')->unique();
            $table->softDeletes();
//            $table->string('nom');
//            $table->string('nationalite');
//            $table->string('ville');
//            $table->string('pays');
//            $table->string('telephone');
//            $table->string('email');
//            $table->string('prenom')->nullable();
//            $table->string('quartier')->nullable();
//            $table->integer('code_postal')->nullable();
            $table->foreign('user_id')
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
        Schema::dropIfExists('souscripteurs', function (Blueprint $table) {
            $table->dropForeign('user_id');
        });
    }
}
