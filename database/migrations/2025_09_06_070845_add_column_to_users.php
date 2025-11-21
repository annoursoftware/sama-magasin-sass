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
        Schema::table('users', function (Blueprint $table) {
            $table->char('sexe', 1)->after('name');
            $table->string('username')->after('email')->unique();
            $table->string('adresse')->nullable();
            $table->string('indicatif', 4)->nullable();
            $table->string('telephone', 15)->nullable();
            $table->string('telephone_secondaire', 15)->nullable();
            $table->boolean('responsable')->default(0); /* Definit si il est responsable ou pas */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('sexe');
            $table->dropColumn('username');
            $table->dropColumn('adresse');
            $table->dropColumn('indicatif');
            $table->dropColumn('telephone');
            $table->dropColumn('telephone_secondaire');
            $table->dropColumn('responsable');
        });
    }
};
