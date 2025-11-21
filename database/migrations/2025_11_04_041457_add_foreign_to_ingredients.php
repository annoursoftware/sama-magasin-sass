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
        Schema::table('ingredients', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->bigInteger('categorie_id')->unsigned()->nullable();
            $table->foreign('categorie_id')->references('id')->on('categories');

            $table->bigInteger('boutique_id')->unsigned()->nullable();
            $table->foreign('boutique_id')->references('id')->on('boutiques');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingredients', function (Blueprint $table) {
            $table->dropForeign('ingredients_user_id_foreign');
            $table->dropColumn('user_id');
            
            $table->dropForeign('ingredients_categorie_id_foreign');
            $table->dropColumn('categorie_id');

            $table->dropForeign('ingredients_boutique_id_foreign');
            $table->dropColumn('boutique_id');
        });
    }
};
