<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffresPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offres_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('commande_id');
            $table->unsignedBigInteger('souscripteur_id');
            $table->date("date_payment");
            $table->string("montant");
            $table->string("status");
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('commande_id')->references('id')->on('offres_packages_commandes')->onDelete('RESTRICT')->onUpdate('RESTRICT');
            $table->foreign('souscripteur_id')->references('user_id')->on('souscripteurs')->onDelete('RESTRICT')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offres_payments');
    }
}
