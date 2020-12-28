<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdonanceMedicamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordonance_medicament', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ordonance_id');
            $table->unsignedBigInteger('medicament_id');
            $table->string('slug');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('ordonance_id')
                ->references('id')
                ->on('ordonances')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('medicament_id')
                ->references('id')
                ->on('medicaments')
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
        Schema::dropIfExists('ordonance_medicament', function (Blueprint $table) {
            $table->dropForeign(['medicament_id', 'ordonance_id']);
        });
    }
}
