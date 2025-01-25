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
        Schema::create('site_infos', function (Blueprint $table) {
            $table->id();
            $table->string('app_name');
            $table->string('home_page_title');
            $table->string('product_page_title');
            $table->string('phone_number');
            $table->string('whatsapp_number');
            $table->string('address')->nullable();
            $table->string('store_phone_number')->nullable(); 
          
            $table->string('store_gateway_image')->nullable();
            $table->string('store_email')->nullable(); 
            $table->string('facebook_url')->nullable(); 
            $table->string('tiktok_url')->nullable(); 
            $table->string('youtube_url')->nullable(); 
            $table->string('instagram_url')->nullable();
            $table->string('x_url')->nullable(); 
            $table->integer('enable_facebook_login');
            $table->integer('enable_google_login');
            $table->decimal('shipping_charge_inside_dhaka', 8, 2)->nullable(); 
            $table->decimal('shipping_charge_outside_dhaka', 8, 2)->nullable();
            $table->string('quantity_indicator', 255)->default('in_stock');
            $table->text('checkout_page_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_infos');
    }
};
