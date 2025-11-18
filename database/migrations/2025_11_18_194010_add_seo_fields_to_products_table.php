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
        Schema::table('products', function (Blueprint $table) {
            $table->string('brand')->nullable()->after('title');
            $table->string('gtin')->nullable()->after('sku')->comment('Global Trade Item Number (barcode)');
            $table->string('mpn')->nullable()->after('gtin')->comment('Manufacturer Part Number');
            $table->enum('condition', ['new', 'refurbished', 'used'])->default('new')->after('mpn');
            $table->string('currency', 3)->default('LKR')->after('sale_price');
            $table->date('price_valid_until')->nullable()->after('currency');
            $table->date('availability_date')->nullable()->after('qty')->comment('When product will be back in stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'brand',
                'gtin',
                'mpn',
                'condition',
                'currency',
                'price_valid_until',
                'availability_date',
            ]);
        });
    }
};
