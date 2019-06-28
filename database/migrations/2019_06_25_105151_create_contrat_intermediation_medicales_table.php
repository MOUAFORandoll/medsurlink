<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratIntermediationMedicalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrat_intermediation_medicales', function (Blueprint $table) {
            $table->bigIncrements('id');
//            Information Patient
            $table->enum('sexePatient',['M','Mme']);
            $table->string('nomPatient');
            $table->string('prenomPatient')->nullable();

//            Infomration Souscripteur
            $table->enum('typeSouscription',['Annuelle','One shot']);
            $table->enum('paysSouscription',['Belgique','Cameroun']);
            $table->enum('lieuEtablissement',['Douala','Irchonwelz']);
            $table->string('nomSouscripteur');
            $table->string('paysResidenceSouscripteur');
            $table->string('villeResidenceSouscripteur');
            $table->string('telephoneSouscripeur1');
            $table->string('telephoneSouscripeur2')->nullable();
            $table->string('emailSouscripteur1');
            $table->string('emailSouscripteur2')->nullable();
            $table->enum('sexeSouscripteur',['M','Mme']);

//            Information Affilié
            $table->enum('sexeAffilie',['M','Mme']);
            $table->string('nomAffilie');
            $table->date('dateNaissanceAffilie')->nullable();
            $table->integer('ageAffilie');
            $table->string('paysResidenceAffilie');
            $table->string('villeResidenceAffilie');
            $table->string('telephoneAffilie1');
            $table->string('telephoneAffilie2')->nullable();
            $table->string('personneContact1')->nullable();
            $table->string('personneContact2')->nullable();
            $table->string('nomContact')->nullable();
            $table->string('montantSouscription')->nullable();

            $table->date('dateSignature');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contrat_intermediation_medicales');
    }
}
