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
        Schema::table('depenses', function (Blueprint $table) {
            $table->bigInteger('beneficiaire_id')->unsigned()->nullable();
            $table->foreign('beneficiaire_id')->references('id')->on('beneficiaires');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('depenses', function (Blueprint $table) {
            $table->dropForeign('depenses_beneficiaire_id_foreign');
            $table->dropColumn('beneficiaire_id');
        });
    }
};
