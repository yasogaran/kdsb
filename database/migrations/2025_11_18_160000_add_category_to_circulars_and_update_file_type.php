<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('circulars', function (Blueprint $table) {
            $table->string('category')->nullable()->after('title');
        });

        // Update file_type enum to include 'file' and 'url'
        DB::statement("ALTER TABLE circulars MODIFY file_type ENUM('file', 'url', 'pdf_upload', 'drive_link', 'doc_upload')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('circulars', function (Blueprint $table) {
            $table->dropColumn('category');
        });

        // Revert file_type enum
        DB::statement("ALTER TABLE circulars MODIFY file_type ENUM('pdf_upload', 'drive_link', 'doc_upload')");
    }
};
