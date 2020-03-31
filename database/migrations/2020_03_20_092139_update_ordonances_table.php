<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrdonancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ordonances', function (Blueprint $table) {
            $table->unsignedBigInteger('praticien_id');
            $table->unsignedBigInteger('prescription_id');

            $table->foreign('praticien_id')
                ->references('user_id')
                ->on('praticiens')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');

            $table->foreign('prescription_id')
                ->references('id')
                ->on('precriptions')
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
        Schema::table('ordonances', function (Blueprint $table) {
            $table->dropForeign('praticien_id','prescription_id');
            $table->dropColumn('praticien_id','prescription_id');
        });
    }
}
