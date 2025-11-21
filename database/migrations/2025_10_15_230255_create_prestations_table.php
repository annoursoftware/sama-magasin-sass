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
        Schema::create('prestations', function (Blueprint $table) {
            $table->id();
            $table->string('code_prestation', 10);
            $table->boolean('etat')->default(1)->comment('1=en cours, 0=annulée');
            $table->char('status_prestation', 1)->comment('d=devis, f=facture');
            $table->double('montant')->default(0)->comment('facture totale de la prestation');
            $table->double('remise')->default(0)->comment('remise de la prestation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestations');
    }
};
