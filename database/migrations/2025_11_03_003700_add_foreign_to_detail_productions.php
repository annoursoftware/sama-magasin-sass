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
        Schema::table('detail_productions', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->bigInteger('production_id')->unsigned()->nullable();
            $table->foreign('production_id')->references('id')->on('productions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_productions', function (Blueprint $table) {
            $table->dropForeign('detail_productions_user_id_foreign');
            $table->dropColumn('user_id');
            
            $table->dropForeign('detail_productions_production_id_foreign');
            $table->dropColumn('production_id');
        });
    }
};
