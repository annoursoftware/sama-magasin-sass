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
        Schema::table('encaissements', function (Blueprint $table) {
            $table->bigInteger('prestation_id')->unsigned()->nullable();
            $table->foreign('prestation_id')->references('id')->on('prestations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('encaissements', function (Blueprint $table) {
            $table->dropForeign('encaissements_prestation_id_foreign');
            $table->dropColumn('prestation_id');
        });
    }
};
