<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToAffiliationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('affiliations', function (Blueprint $table) {
            $table->unsignedBigInteger('souscripteur_id')->nullable();
            $table->unsignedBigInteger('package_id')->nullable();
            $table->unsignedBigInteger('paiement_id')->nullable();
            $table->date('date_signature')->nullable();
            $table->string('status_contrat');
            $table->string('status_paiement');
            $table->boolean('renouvelle');
            $table->boolean('expire');
            $table->string('code_contrat');
            $table->integer('niveau_urgence');
            $table->integer('nombre_envois_email');
            $table->integer('expire_email');


            $table->foreign('souscripteur_id')->references('user_id')->on('souscripteurs')->onDelete('RESTRICT')->onUpdate('RESTRICT');
            $table->foreign('package_id')->references('id')->on('offres_packages')->onDelete('RESTRICT')->onUpdate('RESTRICT');
            $table->foreign('paiement_id')->references('id')->on('offres_payments')->onDelete('RESTRICT')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('affiliations', function (Blueprint $table) {
            //
        });
    }
}
