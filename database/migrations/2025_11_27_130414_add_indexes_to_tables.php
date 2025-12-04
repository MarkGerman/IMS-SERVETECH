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
        Schema::table('users', function (Blueprint $table) {
            $table->index('slug');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->index('category_id');
            $table->index('brand');
            $table->index('barcode');
        });

        Schema::table('purchase_items', function (Blueprint $table) {
            $table->index('purchase_id');
            $table->index('product_id');
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->index('customer_id');
            $table->index('created_by');
        });

        Schema::table('sale_items', function (Blueprint $table) {
            $table->index('sale_id');
            $table->index('product_id');
        });

        Schema::table('returns', function (Blueprint $table) {
            $table->index('sale_id');
            $table->index('customer_id');
            $table->index('approved_by');
            $table->index('created_by');
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->index('created_by');
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->index('supplier_id');
            $table->index('created_by');
        });

        Schema::table('return_items', function (Blueprint $table) {
            $table->index('sale_item_id');
            $table->index('approved_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['slug']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['category_id']);
            $table->dropIndex(['brand']);
            $table->dropIndex(['barcode']);
        });

        Schema::table('purchase_items', function (Blueprint $table) {
            $table->dropIndex(['purchase_id']);
            $table->dropIndex(['product_id']);
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->dropIndex(['customer_id']);
            $table->dropIndex(['created_by']);
        });

        Schema::table('sale_items', function (Blueprint $table) {
            $table->dropIndex(['sale_id']);
            $table->dropIndex(['product_id']);
        });

        Schema::table('returns', function (Blueprint $table) {
            $table->dropIndex(['sale_id']);
            $table->dropIndex(['customer_id']);
            $table->dropIndex(['approved_by']);
            $table->dropIndex(['created_by']);
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->dropIndex(['created_by']);
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->dropIndex(['supplier_id']);
            $table->dropIndex(['created_by']);
        });

        Schema::table('return_items', function (Blueprint $table) {
            $table->dropIndex(['sale_item_id']);
            $table->dropIndex(['approved_by']);
        });
    }
};