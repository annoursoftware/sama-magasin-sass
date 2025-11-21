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
        Schema::create('detail_productions', function (Blueprint $table) {
            $table->id();
            $table->double('quantite')->comment('la quantité peut-être un entier ou une fraction');
            $table->boolean('etat')->default(1)->comment('etat de la ligne de production: 0=périmée, 1=active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_productions');
    }
};
