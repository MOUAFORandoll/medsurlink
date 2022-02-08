<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sender_id')->unsigned();
            $table->unsignedBigInteger('receiver_id')->unsigned();
            $table->text('body');
            $table->enum('type', ['Text', 'Image', 'File', 'Validation Prix', 'Validation Examen'])->default('Text');
            $table->timestamps();

            $table->foreign('sender_id')
            ->references('id')
            ->on('users')
            ->onDelete('RESTRICT')
            ->onUpdate('RESTRICT');
            $table->foreign('receiver_id')
            ->references('id')
            ->on('users')
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
        Schema::dropIfExists('messages');
    }
}
