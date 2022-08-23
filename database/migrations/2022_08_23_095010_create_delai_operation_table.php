<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDelaiOperationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delai_operations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('type_operation_id');
            $table->dateTime('date_heure_prevue');
            $table->dateTime('date_heure_effectif');
            $table->longText('observation')->nullable();
            $table->foreign('patient_id')->references('user_id')->on('patients')->onDelete('Cascade');
            $table->foreign('type_operation_id')->references('id')->on('type_operations')->onDelete('Cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delai_operations');
    }
}
