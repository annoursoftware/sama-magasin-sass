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
        Schema::table('detail_ventes', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->bigInteger('article_id')->unsigned()->nullable();
            $table->foreign('article_id')->references('id')->on('articles');
            
            $table->bigInteger('vente_id')->unsigned()->nullable();
            $table->foreign('vente_id')->references('id')->on('ventes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_ventes', function (Blueprint $table) {
            $table->dropForeign('detail_ventes_user_id_foreign');
            $table->dropColumn('user_id');
            
            $table->dropForeign('detail_ventes_vente_id_foreign');
            $table->dropColumn('vente_id');

            $table->dropForeign('detail_ventes_article_id_foreign');
            $table->dropColumn('article_id');
        });
    }
};
