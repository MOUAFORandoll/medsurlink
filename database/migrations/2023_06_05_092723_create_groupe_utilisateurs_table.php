<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupeUtilisateursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupe_utilisateurs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('groupe_utilisateur_user', function (Blueprint $table) {
            $table->bigInteger('groupe_utilisateur_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();

            $table->foreign('groupe_utilisateur_id')->references('id')->on('groupe_utilisateurs')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('messageables', function (Blueprint $table) {
            $table->bigInteger('message_id');
            $table->bigInteger('messageable_id');
            $table->string('messageable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(['groupe_utilisateur_user', 'groupe_utilisateurs', 'messageables']);
    }
}
