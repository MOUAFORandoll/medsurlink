<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactureAvisDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facture_avis_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('medecin_avis_id');
            $table->unsignedBigInteger('facture_avis_id');
            $table->string('total_montant')->nullable();
            $table->string('medicasure_montant')->nullable();
            $table->string('association_montant')->nullable();
            $table->string('medecin_avis_montant')->nullable();
            $table->string('slug');
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('medecin_avis_id')
                ->references('id')
                ->on('medecin_avis')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('facture_avis_id')
                ->references('id')
                ->on('facture_avis')
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
        Schema::dropIfExists('facture_avis_details');
    }
}
