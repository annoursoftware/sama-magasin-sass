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
        Schema::create('moyens_paiements', function (Blueprint $table) {
            $table->id();
            $table->string('systeme', 20)->comment('Mobile money, Bank, Espece');
            $table->string('entite', 100)->comment('Wave, OM, BIS, BOA, Ecobank, Espece');
            $table->boolean('etat')->default(1)->comment('Etat moyen de paiement');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moyens_paiements');
    }
};
