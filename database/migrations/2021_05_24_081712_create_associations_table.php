<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssociationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('associations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('creator')->nullable();
            $table->unsignedBigInteger('responsable')->nullable();
            $table->string('region')->nullable();
            $table->string('ville')->nullable();
            $table->string('nom')->nullable();
            $table->string('telephone')->nullable();
            $table->string('localisation')->nullable();
            $table->string('email')->nullable();
            $table->text('contact')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('responsable')
            ->references('id')
            ->on('users')
            ->onDelete('RESTRICT')
            ->onUpdate('RESTRICT');

            $table->foreign('creator')
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
        Schema::dropIfExists('associations');
    }
}
