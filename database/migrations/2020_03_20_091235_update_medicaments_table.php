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
            $table->string('nom_commercial')->nullable()->change();
            $table->string('principe_actif')->nullable()->change();
            $table->string('classe_medicamenteuse')->nullable()->change();
            $table->string('forme_et_dosage')->nullable()->change();
            $table->string('conditionement')->nullable()->change();
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
