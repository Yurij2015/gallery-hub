<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('projects')->whereNull('download_statistic')->update(['download_statistic' => 0]);

        Schema::table('projects', function (Blueprint $table) {
            $table->integer('download_statistic')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->integer('download_statistic')->default(null)->change();
        });
    }
};
