<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('features', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom_feature');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('feature_id')->nullable();
            $table->foreign('feature_id')->references('id')->on('features')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('features');

        Schema::table('permissions', function (Blueprint $table) {
            $table->dropForeign(['feature_id']);
            $table->dropColumn('feature_id');
        });
    }
}
