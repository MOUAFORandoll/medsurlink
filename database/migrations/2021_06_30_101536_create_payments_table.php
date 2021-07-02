<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('souscripteur_id');
            $table->unsignedBigInteger('patient_id');
            $table->smallInteger('amount');
            $table->date('date_payment')->nullable();
            $table->string('method');
            $table->string('motif');
            $table->string('statut');
            $table->string('slug');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('souscripteur_id')
            ->references('user_id')
            ->on('souscripteurs')
            ->onDelete('RESTRICT')
            ->onUpdate('RESTRICT');

            $table->foreign('patient_id')
            ->references('user_id')
            ->on('patients')
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
        Schema::dropIfExists('payments');
    }
}
