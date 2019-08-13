<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEchographiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('echographies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('consultation_obstetrique_id');
            $table->date('date_creation')->default(\Carbon\Carbon::now()->format('Y-m-d'));
            $table->string('type');
            $table->date('ddr');
            $table->date('dpa');
            $table->integer('semaine_amenorrhee')->nullable();
            $table->text('biometrie')->nullable();
            $table->text('annexe')->nullable();
            $table->text('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->string('slug')->unique();

            $table->foreign('consultation_obstetrique_id')
                ->references('id')
                ->on('consultation_obstetriques')
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
        Schema::dropIfExists('echographies', function (Blueprint $table) {
            $table->dropForeign(['consultation_obstetrique_id']);
        });
    }
}
