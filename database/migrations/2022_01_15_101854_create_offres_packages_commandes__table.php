<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffresPackagesCommandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offres_packages_commandes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('offres_packages_id');
            $table->unsignedBigInteger('souscripteur_id');
            $table->string('quantite');
            $table->date('date_commande');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('souscripteur_id')->references('user_id')->on('souscripteurs')->onDelete('RESTRICT')->onUpdate('RESTRICT');
            $table->foreign('offres_packages_id')->references('id')->on('offres_packages')->onDelete('RESTRICT')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offres_packages_commandes');
    }
}
