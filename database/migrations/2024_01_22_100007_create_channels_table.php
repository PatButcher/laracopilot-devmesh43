<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('type', ['tracks', 'albums', 'artists', 'playlists', 'genres', 'mixed'])->default('tracks');
            $table->foreignId('genre_id')->nullable()->constrained()->onDelete('set null');
            $table->string('color')->nullable()->default('#8B5CF6');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('channels'); }
};