<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('system_organization_name')->nullable();
            $table->string('system_phone_1')->nullable();
            $table->string('system_phone_2')->nullable();
            $table->string('system_phone_3')->nullable();
            $table->string('logo')->nullable();
            $table->string('shop_name')->nullable();
            $table->string('shop_email')->nullable();
            $table->string('shop_phone')->nullable();
            $table->string('shop_address')->nullable();
            $table->decimal('markup_percentage', 5, 2)->default(0); // e.g. 15 = 15%
            $table->decimal('tax_percentage', 5, 2)->default(0);
            $table->boolean('pos_enabled')->default(true);
            $table->boolean('allow_negative_stock')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
