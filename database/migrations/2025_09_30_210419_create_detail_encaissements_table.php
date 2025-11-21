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
        Schema::create('detail_encaissements', function (Blueprint $table) {
            $table->id();
            $table->string('mode_encaissement', 50);
            $table->string('ref_encaissement', 75);
            $table->string('lieu_encaissement', 75);
            $table->double('montant')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_encaissements');
    }
};
