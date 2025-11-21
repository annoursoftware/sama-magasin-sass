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
        Schema::create('fournisseurs', function (Blueprint $table) {
            $table->id();
            $table->string('fournisseur');
            $table->char('type', 1)->comment('i: informel, f: formel');
            $table->string('telephone', 20)->nullable();
            $table->char('email', 100)->nullable();
            $table->char('adresse', 100)->nullable()->comment('Adresse du fournisseur');
            $table->char('ninea', 20)->nullable()->comment('Ninea');
            $table->char('rc', 20)->nullable()->comment('registre de commerce');
            $table->char('regime_juridique', 100)->nullable()->comment('régime juridique');
            $table->boolean('etat')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fournisseurs');
    }
};
