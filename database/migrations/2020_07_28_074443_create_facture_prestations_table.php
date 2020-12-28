<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturePrestationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facture_prestations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('facture_id');
            $table->unsignedBigInteger('prestation_id');
            $table->unsignedBigInteger('creator')->nullable();
            $table->date('date_prestation')->nullable();
            $table->string('slug');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facture_id')
                ->references('id')
                ->on('factures')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('prestation_id')
                ->references('id')
                ->on('etablissement_prestation')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('creator')
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
        Schema::dropIfExists('facture_prestations');
    }
}
