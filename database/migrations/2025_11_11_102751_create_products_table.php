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
    $table->string('name');
    $table->integer('category_id');
    $table->string('brand');
    $table->decimal('purchase_price', 10, 2);
    $table->decimal('selling_price', 10, 2);
    $table->integer('quantity')->default(0);
    $table->integer('reorder_level')->default(5);
    $table->string('barcode')->nullable();
    $table->text('description')->nullable();
    $table->timestamps();
    $table->softDeletes();
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
