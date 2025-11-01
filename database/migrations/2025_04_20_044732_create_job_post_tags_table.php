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
        Schema::create('job_post_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_post_id')->constrained()->onDelete('cascade');
            $table->enum('tag', ['pin', 'truss', 'pre_stay', 'post_stay']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_post_tags');
    }
};
