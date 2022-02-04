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
            $table->unsignedBigInteger('souscripteur_id');
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('paiement_id');
            $table->date('date_signature');
            $table->string('status_contrat');
            $table->string('status_paiement');
            $table->boolean('renouvelle');
            $table->boolean('expire');
            $table->string('code_contrat');
            $table->bigIncrements('niveau_urgence');
            $table->bigIncrements('nombre_envois_email');
            $table->bigIncrements('expire_email');


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
