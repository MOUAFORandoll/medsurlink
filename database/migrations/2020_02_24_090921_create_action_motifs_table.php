<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionMotifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_motifs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('actionable');
            $table->unsignedBigInteger('motif_id');
            $table->string('slug');
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('action_motifs', function (Blueprint $table) {
           $table->dropMorphs('actionable');
        });
    }
}
