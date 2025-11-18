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
        Schema::create('circulars', function (Blueprint $table) {
            $table->id();
            $table->string('circular_number')->unique();
            $table->string('circular_code')->nullable();
            $table->string('title');
            $table->enum('file_type', ['pdf_upload', 'drive_link', 'doc_upload']);
            $table->string('file_path')->nullable();
            $table->string('external_link')->nullable();
            $table->date('published_date');
            $table->boolean('is_pinned')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circulars');
    }
};
