<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offre_package_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('package_id')->nullable();
            $table->unsignedBigInteger('key')->nullable();
            $table->string('reference')->nullable();
            $table->String("value")->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('package_id')->references('id')->on('offres_packages')->onDelete('RESTRICT')->onUpdate('RESTRICT');
            $table->foreign('key')->references('id')->on('dictionnaires')->onDelete('RESTRICT')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offre_package_items');
    }
}
