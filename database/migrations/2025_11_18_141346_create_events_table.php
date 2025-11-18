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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->dateTime('registration_deadline')->nullable();
            $table->enum('location_type', ['physical', 'online', 'hybrid']);
            $table->string('venue_name')->nullable();
            $table->text('address')->nullable();
            $table->text('map_link')->nullable();
            $table->string('meeting_url')->nullable();
            $table->text('summary');
            $table->longText('content');
            $table->string('banner_image')->nullable();
            $table->string('thumbnail_image')->nullable();
            $table->string('organized_by')->nullable();
            $table->string('organization_link')->nullable();
            $table->enum('status', ['draft', 'published', 'started', 'cancelled', 'postponed'])->default('draft');

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
        Schema::dropIfExists('events');
    }
};
