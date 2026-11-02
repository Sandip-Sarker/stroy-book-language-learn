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
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('song_category_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('artist_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('title');
            $table->string('short_description')->nullable();
            $table->string('image')->nullable();
            $table->string('audio')->nullable();
            $table->enum('difficult', ['Beginner', 'Intermediate', 'Advanced'])->default('Beginner');
            $table->boolean('is_exclusive')->default(true);
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
