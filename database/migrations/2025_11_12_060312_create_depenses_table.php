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
        Schema::create('depenses', function (Blueprint $table) {
            $table->id();
            $table->string('num_depense', 10);
            $table->string('libelle');
            $table->string('numero_facture_benef', 20)->nullable();
            $table->boolean('etat')->default(1)->comment('0=annule et 1=en validation, 2=validé');
            $table->double('montant')->default(0);
            $table->char('type', 5)->default('dir')->comment('dir=directe, dif=differe');
            $table->date('effet')->nullable();
            $table->date('limite')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depenses');
    }
};
