<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMotifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motifs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference');
            $table->text('description');
            $table->softDeletes();
            $table->timestamps();
            $table->string('slug')->unique();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('motifs');
    }
}
