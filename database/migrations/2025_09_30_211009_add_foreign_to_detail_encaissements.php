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
        Schema::table('detail_encaissements', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->bigInteger('encaissement_id')->unsigned()->nullable();
            $table->foreign('encaissement_id')->references('id')->on('encaissements');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_encaissements', function (Blueprint $table) {
            $table->dropForeign('detail_encaissements_user_id_foreign');
            $table->dropColumn('user_id');
            
            $table->dropForeign('detail_encaissements_encaissement_id_foreign');
            $table->dropColumn('encaissement_id');
        });
    }
};
