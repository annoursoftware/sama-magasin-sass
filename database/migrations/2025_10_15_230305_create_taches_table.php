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
        Schema::create('taches', function (Blueprint $table) {
            $table->id();
            $table->double('montant');
            $table->double('duree')->default(0)->comment('si la durée est 0 alors le montant est pris tout seul, sinon elle est calculé avec le montant');
            $table->boolean('etat')->default(1)->comment('etat de la ligne de tache: 0=annulée, 1=active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taches');
    }
};
