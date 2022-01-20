<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationPaiementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_paiements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->nullable();
            $table->string('code_contrat')->nullable();
            $table->string('pay_token')->nullable();
            $table->string('statut')->nullable();
            $table->json('reponse')->nullable();
            $table->string('slug')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('notification_paiements');
    }
}
