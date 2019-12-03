<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePraticiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('praticiens', function (Blueprint $table) {
//            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('specialite_id');
            $table->enum('civilite',['M.','Mme/Mlle.','Dr.','Pr.']);
            $table->softDeletes();
            $table->string('numero_ordre');
            $table->timestamps();
            $table->string('slug')->unique();
//            $table->string('nom');
//            $table->string('prenom')->nullable();
//            $table->string('nationalite');
//            $table->string('quartier')->nullable();
//            $table->integer('code_postal')->nullable();
//            $table->string('ville');
//            $table->string('pays');
//            $table->string('telephone');
//            $table->string('email');


            $table->foreign('specialite_id')
                ->references('id')
                ->on('specialites')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

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
        Schema::dropIfExists('praticiens', function (Blueprint $table) {
            $table->drop(['profession_id','specialite_id','user_id']);
        });
    }
}
