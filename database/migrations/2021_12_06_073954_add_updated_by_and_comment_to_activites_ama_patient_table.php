<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUpdatedByAndCommentToActivitesAmaPatientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activites_ama_patient', function (Blueprint $table) {
            /*$table->longText('commentaire')->nullable();
            $table->unsignedBigInteger('updated_by')->unsigned();
            $table->foreign('updated_by')
            ->references('id')
            ->on('users')
            ->onDelete('RESTRICT')
            ->onUpdate('RESTRICT');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activites_ama_patient');
    }
}
