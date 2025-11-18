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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->enum('layout_type', ['grid', 'masonry', 'slider'])->default('grid');
            $table->foreignId('event_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('visibility', ['public', 'private'])->default('public');
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->date('date_taken')->nullable();
            $table->integer('image_count')->default(0);

            // SEO Fields
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
