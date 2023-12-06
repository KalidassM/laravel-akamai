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
        Schema::table('whitelists', function (Blueprint $table) {
            $table->integer('status')->default(1)->after('ipv6'); // 1 = ADDED, 2 = INPROGRESS, 3 = ACTIVATED
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('whitelists', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
