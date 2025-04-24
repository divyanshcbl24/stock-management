<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'sku')) {
                $table->string('sku')->unique()->after('name');
            }
            if (!Schema::hasColumn('products', 'category_id')) {
                $table->foreignId('category_id')->nullable()->constrained()->after('description');
            }
            if (!Schema::hasColumn('products', 'vendor_id')) {
                $table->foreignId('vendor_id')->nullable()->constrained()->after('category_id');
            }
            if (!Schema::hasColumn('products', 'image_path')) {
                $table->string('image_path')->nullable()->after('vendor_id');
            }
            $table->renameColumn('stock', 'quantity');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'sku')) {
                $table->dropColumn('sku');
            }
            if (Schema::hasColumn('products', 'image_path')) {
                $table->dropColumn('image_path');
            }
            if (Schema::hasColumn('products', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
            if (Schema::hasColumn('products', 'vendor_id')) {
                $table->dropForeign(['vendor_id']);
                $table->dropColumn('vendor_id');
            }
            $table->renameColumn('quantity', 'stock');
        });
    }
};
