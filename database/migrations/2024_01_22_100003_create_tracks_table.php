<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('artist_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('album_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('genre_id')->nullable()->constrained()->onDelete('set null');
            $table->text('description')->nullable();
            $table->string('audio_path');
            $table->string('cover_image')->nullable();
            $table->integer('duration')->default(0);
            $table->unsignedBigInteger('play_count')->default(0);
            $table->text('tags')->nullable();
            $table->text('lyrics')->nullable();
            $table->integer('track_number')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('tracks'); }
};