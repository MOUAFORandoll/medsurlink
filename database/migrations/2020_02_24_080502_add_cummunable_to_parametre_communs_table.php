<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCummunableToParametreCommunsTable extends Migration
{
    /**
     * Je me suis rendu compte avec la création de l'entite consultation que l'entite paramètre commun devrait être
     * polymorphe avec que ces attributs puissent être utilisé par plusieurs autres entités
     *
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parametre_communs', function (Blueprint $table) {
            $table->nullableMorphs('communable');
            $table->dropForeign('parametre_communs_consultation_medecine_generale_id_foreign');
            $table->unsignedBigInteger('consultation_medecine_generale_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parametre_communs', function (Blueprint $table) {
            $table->dropMorphs('communable');
            $table->foreign('consultation_medecine_generale_id')
                ->references('id')
                ->on('consultation_medecine_generales')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');
        });
    }
}
