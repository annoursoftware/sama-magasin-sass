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
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();
            $table->string('num_vente');
            $table->boolean('etat')->comment('1=en cours, 0=annulée');
            $table->char('status_vente', 1)->comment('d=devis, f=facture');
            $table->double('montant')->default(0)->comment('montant total de la vente');
            $table->double('remise')->default(0)->comment('remise de la vente');
            $table->double('montant_apres_remise')->default(0)->comment('montant total de la vente apres remise');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventes');
    }
};
