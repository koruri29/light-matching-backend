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
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->string('event_name');
            $table->string('prefecture');
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->string('payment', 200)->nullable();
            $table->enum('contact_method', ['email', 'line'])->default('email');
            $table->boolean('is_public')->default(true);
            $table->boolean('is_closed')->default(false);
            $table->timestamp('deadline')->nullable();
            $table->integer('number_of_position')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};
