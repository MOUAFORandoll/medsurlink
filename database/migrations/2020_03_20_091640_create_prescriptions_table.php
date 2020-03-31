<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('medicament_id');
            $table->unsignedBigInteger('posologie_id');
            $table->unsignedBigInteger('ordonance_id');
            $table->string('info_comp')->nullable();
            $table->date('date_fin');
            $table->string('slug')->unique();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('medicament_id')
                ->references('id')
                ->on('medicaments')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('posologie_id')
                ->references('id')
                ->on('posologies')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('ordonance_id')
                ->references('id')
                ->on('ordonances')
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
        Schema::dropIfExists('prescriptions');
    }
}
