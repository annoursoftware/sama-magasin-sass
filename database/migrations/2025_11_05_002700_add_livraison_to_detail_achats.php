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
        Schema::table('detail_achats', function (Blueprint $table) {
            $table->double('livraison')->default(0)->after('quantite')->comment('quantité à livrer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_achats', function (Blueprint $table) {
            $table->dropColumn('livraison');
        });
    }
};
