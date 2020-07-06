<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuiviToDoListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suivi_to_do_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->nullableMorphs('listable');
            $table->string('intitule')->nullable();
            $table->longText('description')->nullable();
            $table->string('statut')->nullable();
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
        Schema::dropIfExists('suivi_to_do_lists');
    }
}
