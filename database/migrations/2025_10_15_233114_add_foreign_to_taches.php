<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('taches', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->bigInteger('prestation_id')->unsigned()->nullable();
            $table->foreign('prestation_id')->references('id')->on('prestations');

            $table->bigInteger('activite_id')->unsigned()->nullable();
            $table->foreign('activite_id')->references('id')->on('activites');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('taches', function (Blueprint $table) {
            $table->dropForeign('taches_user_id_foreign');
            $table->dropColumn('user_id');
            
            $table->dropForeign('taches_prestation_id_foreign');
            $table->dropColumn('prestation_id');

            $table->dropForeign('taches_activite_id_foreign');
            $table->dropColumn('activite_id');
        });
    }
};
