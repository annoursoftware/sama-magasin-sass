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
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->string('entreprise');
            $table->string('logo')->nullable();
            $table->string('telephone_primaire', 20);
            $table->string('email', 150)->unique();
            $table->string('responsable', 100);
            $table->string('ninea', 15);
            $table->string('rc', 15);
            $table->string('siege', 100);
            $table->string('regime_juridique', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entreprises');
    }
};
