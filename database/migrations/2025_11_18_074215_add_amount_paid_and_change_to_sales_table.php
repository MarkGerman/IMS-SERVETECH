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
        Schema::table('sales', function (Blueprint $table) {
            // dev by Techlink360: Add amount_paid and change columns to the sales table
            $table->decimal('amount_paid', 10, 2)->nullable()->after('total_amount');
            $table->decimal('change', 10, 2)->nullable()->after('amount_paid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            // dev by Techlink360: Drop amount_paid and change columns from the sales table
            $table->dropColumn(['amount_paid', 'change']);
        });
    }
};
