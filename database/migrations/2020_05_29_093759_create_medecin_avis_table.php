<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedecinAvisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medecin_avis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('avis_id');
            $table->unsignedBigInteger('medecin_id');
            $table->string('slug');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('medecin_id')
                ->references('id')
                ->on('users')
                ->onUpdate('restrict')
                ->onDelete('restrict');

            $table->foreign('avis_id')
                ->references('id')
                ->on('avis')
                ->onUpdate('restrict')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medecin_avis');
    }
}
