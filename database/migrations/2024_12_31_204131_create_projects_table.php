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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('slug')->comment('auto generated');
            $table->string('bucket_name')->comment('generated from username');
            $table->string('project_folder');
            $table->date('date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->integer('views_statistic')->nullable();
            $table->integer('download_statistic')->nullable();
            $table->json('user_reactions')->nullable();
            $table->json('project_statistic')->nullable()->comment('{"views": 0, "downloads": 0, "size": 0, "files": 0}');
            $table->string('project_link')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
