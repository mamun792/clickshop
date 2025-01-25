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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('user_identifier');

            $table->string('customer_name');
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('alternative_phone_number')->nullable();
            $table->string('email');
            $table->text('note')->nullable();
            $table->text('courier_note')->nullable();

            // Enum for order status with default value
            $table->enum('order_status', ['pending', 'processed','shipped', 'returned', 'delivered', 'cancelled','on delivery','pending delivery','incomplete'])->default('pending');
            $table->enum('order_type', ['pos', 'checkout'])->default('checkout');
            // diccoumt field   pos diccont field
            $table->decimal('discount', 10, 2)->default(0);

            // Financial fields
            $table->decimal('total_price', 10, 2);
            $table->decimal('shipping_price', 10, 2);
            $table->decimal('delivery_charge', 10, 2)->nullable();

            // Delivery method
            $table->string('delivery');
            // invoice  number
            $table->string('invoice_number')->nullable();
            $table->string('comment_id')->nullable();
            $table->string('select_area')->nullable();

            $table->string('consignment_id')->nullable();
            $table->string('tracking_code')->nullable();
            $table->string('couriar_status')->nullable();
            $table->string('couriar_name')->nullable();

            $table->string('city_id')->nullable();
            $table->string('zone_id')->nullable();
            $table->string('area_id')->nullable();

            $table->string('city_name')->nullable();
            $table->string('zone_name')->nullable();
            $table->string('area_name')->nullable();

            // $table->string('order_type')->default('checkout');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
