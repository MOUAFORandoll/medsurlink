<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeleHeteroConsultationConclusionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tele_hetero_consultation_conclusions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('consultation_id');
            $table->string('reference');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('slug')->unique();

            $table->foreign('consultation_id')
                ->references('id')
                ->on('tele_hetero_consultation')
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
        Schema::dropIfExists('tele_hetero_consultation_conclusions', function (Blueprint $table) {
            $table->dropForeign(['consultation_id']);
        });
    }
}
