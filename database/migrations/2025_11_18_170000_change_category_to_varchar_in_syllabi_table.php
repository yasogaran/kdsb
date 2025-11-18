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
        // Change category from enum to varchar (to accept any single word)
        DB::statement("ALTER TABLE syllabi MODIFY category VARCHAR(255) NOT NULL");

        // Update resource_type enum to include 'file' and 'url'
        DB::statement("ALTER TABLE syllabi MODIFY resource_type ENUM('file', 'url', 'pdf_upload', 'drive_link', 'video_link', 'doc_upload') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert category back to enum
        DB::statement("ALTER TABLE syllabi MODIFY category ENUM('Singithi', 'Cubs', 'Junior Scouts', 'Senior Scouts', 'Rovers', 'Masters', 'General') NOT NULL");

        // Revert resource_type back to original enum values
        DB::statement("ALTER TABLE syllabi MODIFY resource_type ENUM('pdf_upload', 'drive_link', 'video_link', 'doc_upload') NOT NULL");
    }
};
