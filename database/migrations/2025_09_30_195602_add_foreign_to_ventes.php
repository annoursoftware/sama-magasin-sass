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
        Schema::table('ventes', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->bigInteger('boutique_id')->unsigned()->nullable();
            $table->foreign('boutique_id')->references('id')->on('boutiques');

            $table->bigInteger('client_id')->unsigned()->nullable();
            $table->foreign('client_id')->references('id')->on('clients'); /* ou dans la table users si le client doit accéder au systéme */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ventes', function (Blueprint $table) {
            $table->dropForeign('ventes_user_id_foreign');
            $table->dropColumn('user_id');
            
            $table->dropForeign('ventes_boutique_id_foreign');
            $table->dropColumn('boutique_id');

            $table->dropForeign('ventes_client_id_foreign');
            $table->dropColumn('client_id');
        });
    }
};
