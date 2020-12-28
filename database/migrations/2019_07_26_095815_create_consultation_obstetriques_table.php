<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultationObstetriquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultation_obstetriques', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dossier_medical_id');
            $table->date('date_creation')->default(Carbon\Carbon::now()->format('Y-m-d'));
            $table->integer('numero_grossesse');
            $table->date('ddr');
            $table->text('antecedent_conjoint')->nullable();
            $table->string('serologie')->nullable();
            $table->string('groupe_sanguin')->nullable();
            $table->string('statut_socio_familiale')->nullable();
            $table->text('assuetudes')->nullable();
            $table->text('antecedent_de_transfusion')->nullable();
            $table->text('facteur_de_risque')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->string('slug')->unique();

            $table->foreign('dossier_medical_id')
                ->references('id')
                ->on('dossier_medicals')
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
        Schema::dropIfExists('consultation_obstetriques', function (Blueprint $table) {
            $table->dropForeign('dossier_medical_id');
        });
    }
}
