<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametreObstetriquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametre_obs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('consultation_prenatale_id');
            $table->double('poids')->nullable();
            $table->integer('ta_systolique')->nullable();
            $table->integer('ta_diastolique')->nullable();
            $table->integer('hauteur_urine')->nullable();
            $table->integer('toucher_vaginal')->nullable();
            $table->integer('bruit_du_coeur')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('consultation_prenatale_id')
                ->references('id')
                ->on('consultation_prenatales')
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
        Schema::dropIfExists('parametre_obstetriques', function (Blueprint $table) {
            $table->dropForeign(['consultation_prenatale_id']);
        });
    }
}
