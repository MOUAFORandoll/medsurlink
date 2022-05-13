<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffresPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offres_packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('offre_id');
            $table->string('description_fr')->nullable();
            $table->string('description_en')->nullable();
            $table->json('items')->nullable();
            $table->string('status')->nullable();
            $table->string('montant');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('offre_id')->references('id')->on('offres')->onDelete('RESTRICT')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offres_packages');
    }
}
