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
            $table->bigInteger('depense_id')->unsigned()->nullable();
            $table->foreign('depense_id')->references('id')->on('depenses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('decaissements', function (Blueprint $table) {
            $table->dropForeign('decaissements_depense_id_foreign');
            $table->dropColumn('depense_id');
        });
    }
};
