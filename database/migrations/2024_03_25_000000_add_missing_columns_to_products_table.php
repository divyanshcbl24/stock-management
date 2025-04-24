<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->decimal('price', 10, 2);
                $table->integer('stock_quantity')->default(0);
                $table->string('sku')->unique();
                $table->string('barcode')->nullable();
                $table->string('unit_of_measure')->default('pcs');
                $table->decimal('minimum_stock_level', 10, 2)->default(0);
                $table->decimal('maximum_stock_level', 10, 2)->nullable();
                $table->string('location')->nullable();
                $table->string('image')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        } else {
            Schema::table('products', function (Blueprint $table) {
                if (!Schema::hasColumn('products', 'sku')) {
                    $table->string('sku')->unique();
                }
                if (!Schema::hasColumn('products', 'barcode')) {
                    $table->string('barcode')->nullable();
                }
                if (!Schema::hasColumn('products', 'unit_of_measure')) {
                    $table->string('unit_of_measure')->default('pcs');
                }
                if (!Schema::hasColumn('products', 'minimum_stock_level')) {
                    $table->decimal('minimum_stock_level', 10, 2)->default(0);
                }
                if (!Schema::hasColumn('products', 'maximum_stock_level')) {
                    $table->decimal('maximum_stock_level', 10, 2)->nullable();
                }
                if (!Schema::hasColumn('products', 'location')) {
                    $table->string('location')->nullable();
                }
                if (!Schema::hasColumn('products', 'image')) {
                    $table->string('image')->nullable();
                }
                if (!Schema::hasColumn('products', 'is_active')) {
                    $table->boolean('is_active')->default(true);
                }
                if (!Schema::hasColumn('products', 'stock_quantity')) {
                    $table->integer('stock_quantity')->default(0);
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'sku',
                'barcode',
                'unit_of_measure',
                'minimum_stock_level',
                'maximum_stock_level',
                'location',
                'image',
                'is_active',
                'stock_quantity'
            ]);
        });
    }
};
