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
        Schema::table('detail_decaissements', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->bigInteger('decaissement_id')->unsigned()->nullable();
            $table->foreign('decaissement_id')->references('id')->on('decaissements');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_decaissements', function (Blueprint $table) {
            $table->dropForeign('detail_decaissements_user_id_foreign');
            $table->dropColumn('user_id');
            
            $table->dropForeign('detail_decaissements_decaissement_id_foreign');
            $table->dropColumn('decaissement_id');
        });
    }
};
