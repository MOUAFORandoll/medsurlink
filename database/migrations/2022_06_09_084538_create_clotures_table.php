<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCloturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clotures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cloturable_id');
            $table->string('cloturable_type');
            $table->dateTime("automatique")->nullable();
            $table->dateTime("ama")->nullable();
            $table->dateTime("medecin_referent")->nullable();
            $table->dateTime("gestionnaire")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clotures');
    }
}
