<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGestionnairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gestionnaires', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('civilite',['M.','Mme/Mlle.','Dr.','Pr.']);
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('nationalite');
            $table->string('quartier')->nullable();
            $table->integer('code_postal')->nullable();
            $table->string('ville');
            $table->string('pays');
            $table->string('telephone');
            $table->string('email');
            $table->softDeletes();
            $table->timestamps();

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
        Schema::dropIfExists('gestionnaires', function (Blueprint $table) {
            $table->drop(['user_id']);
        });
    }
}
