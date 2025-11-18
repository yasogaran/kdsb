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
        Schema::create('syllabi', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('category', ['Singithi', 'Cubs', 'Junior Scouts', 'Senior Scouts', 'Rovers', 'Masters', 'General']);
            $table->enum('resource_type', ['pdf_upload', 'drive_link', 'video_link', 'doc_upload']);
            $table->string('file_path')->nullable();
            $table->string('external_url')->nullable();
            $table->text('description')->nullable();
            $table->date('published_date');
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syllabi');
    }
};
