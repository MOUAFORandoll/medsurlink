<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPcrToConsultationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultation_obstetriques', function (Blueprint $table) {
            $table->string('pcr_gonocoque')->default('Non');
            $table->string('pcr_chlamydia')->default('Non');
            $table->string('rcc')->default('Non');
            $table->string('glycemie')->default('0');
            $table->string('emu')->default('négatif');
            $table->string('tsh')->default('0');
            $table->string('anti_tpo')->default('0');
            $table->string('ft4')->default('0');
            $table->string('ft3')->default('0');
            $table->text('attention')->nullable();
            $table->text('info_prise_en_charge')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consultation_obstetriques', function (Blueprint $table) {
            $table->dropColumn(['pcr_gonocoque','pcr_chlamydia','rcc','glycemie','emu','tsh','anti_tpo','ft4','ft3','attention','info_prise_en_charge']);
        });
    }
}
