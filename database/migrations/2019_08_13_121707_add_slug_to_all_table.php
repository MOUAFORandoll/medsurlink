<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugToAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->addColumn('string','slug')->unique();
        });

        Schema::table('users', function (Blueprint $table) {
            //
        });
        Schema::table('users', function (Blueprint $table) {
            //
        });
        Schema::table('users', function (Blueprint $table) {
            //
        });
        Schema::table('users', function (Blueprint $table) {
            //
        });
        Schema::table('users', function (Blueprint $table) {
            //
        });
        Schema::table('users', function (Blueprint $table) {
            //
        });
        Schema::table('users', function (Blueprint $table) {
            //
        });
        Schema::table('users', function (Blueprint $table) {
            //
        });
        Schema::table('users', function (Blueprint $table) {
            //
        });
        Schema::table('users', function (Blueprint $table) {
            //
        });
        Schema::table('users', function (Blueprint $table) {
            //
        });
        Schema::table('users', function (Blueprint $table) {
            //
        });
        Schema::table('users', function (Blueprint $table) {
            //
        });
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
