<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultationPrenatalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultation_prenatales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('consultation_obstetrique_id');
            $table->date('date_creation')->default(\Carbon\Carbon::today()->format('Y-m-d'));
            $table->string('type_de_consultation');
            $table->text('plaintes')->nullable();
            $table->text('antecedent_conjoint')->nullable();
            $table->text('recommandations')->nullable();
            $table->softDeletes();
            $table->timestamps();

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
        Schema::dropIfExists('consultation_prenatales', function (Blueprint $table) {
            $table->dropForeign(['consultation_obstetrique_id']);
        });
    }
}
