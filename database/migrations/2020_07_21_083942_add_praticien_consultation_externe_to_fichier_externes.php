<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPraticienConsultationExterneToFichierExternes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultation_fichiers', function (Blueprint $table) {
            $table->string('praticien_externe')->nullable();
            $table->string('consultation_externe')->nullable();
            $table->dropIndex('user_id');
            $table->dropForeign('user_id');
            $table->string('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consultation_fichiers', function (Blueprint $table) {
            $table->dropColumn('praticien_externe','consultation_externe');
        });
    }
}
