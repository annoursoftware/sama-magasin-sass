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
        Schema::table('achats', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->bigInteger('boutique_id')->unsigned()->nullable();
            $table->foreign('boutique_id')->references('id')->on('boutiques');

            $table->bigInteger('fournisseur_id')->unsigned()->nullable();
            $table->foreign('fournisseur_id')->references('id')->on('fournisseurs'); /* ou dans la table users si le fournisseur doit accéder au systéme */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achats', function (Blueprint $table) {
            $table->dropForeign('achats_user_id_foreign');
            $table->dropColumn('user_id');
            
            $table->dropForeign('achats_boutique_id_foreign');
            $table->dropColumn('boutique_id');

            $table->dropForeign('achats_fournisseur_id_foreign');
            $table->dropColumn('fournisseur_id');
        });
    }
};
