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
        Schema::table('decaissements', function (Blueprint $table) {
            $table->bigInteger('achat_id')->unsigned()->nullable();
            $table->foreign('achat_id')->references('id')->on('achats');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('decaissements', function (Blueprint $table) {
            $table->dropForeign('decaissements_achat_id_foreign');
            $table->dropColumn('achat_id');
        });
    }
};
