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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->text('excerpt');
            $table->longText('content');
            $table->string('image')->nullable();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->dateTime('published_at')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');

            // SEO Fields
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('og_image')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
