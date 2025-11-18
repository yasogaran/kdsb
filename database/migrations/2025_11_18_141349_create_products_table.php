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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->foreignId('category_id')->constrained('product_categories')->cascadeOnDelete();
            $table->string('group')->nullable();
            $table->string('primary_image')->nullable();
            $table->text('about')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->integer('qty')->default(0);
            $table->enum('status', ['available', 'pre_order', 'coming_soon', 'out_of_stock'])->default('available');

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
        Schema::dropIfExists('products');
    }
};
