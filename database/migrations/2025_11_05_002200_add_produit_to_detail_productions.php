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
        Schema::table('detail_productions', function (Blueprint $table) {
            $table->bigInteger('produit_id')->unsigned()->nullable();
            $table->foreign('produit_id')->references('id')->on('produits');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_productions', function (Blueprint $table) {
            $table->dropForeign('detail_productions_produit_id_foreign');
            $table->dropColumn('produit_id');
        });
    }
};
