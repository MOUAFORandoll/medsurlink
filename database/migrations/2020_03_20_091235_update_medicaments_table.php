<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMedicamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medicaments', function (Blueprint $table) {
            $table->string('nom_commercial')->nullable();
            $table->string('principe_actif')->nullable();
            $table->string('classe_medicamenteuse')->nullable();
            $table->string('forme_et_dosage')->nullable();
            $table->string('conditionement')->nullable();
            $table->string('nom_specialite');
            $table->string('nom_dci');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medicaments', function (Blueprint $table) {
            $table->dropColumn('nom_specialite');
            $table->dropColumn('nom_dci');
        });
    }
}
