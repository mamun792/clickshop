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
        Schema::create('incomplete', function (Blueprint $table) {
            $table->id();
            $table->string('user_identifier'); 
            $table->string('customer_name')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('alternative_phone_number')->nullable();
            $table->string('email')->nullable();
            $table->text('note')->nullable(); 
        
            // Enum for order status with default value
            $table->enum('order_status', ['incomplete', 'complete'])->default('incomplete'); 
            
            // Financial fields
            $table->decimal('total_price', 10, 2)->nullable();
            $table->decimal('shipping_price', 10, 2)->nullable();
            $table->decimal('delivery_charge', 10, 2)->nullable();
            
            // Delivery method
            $table->string('delivery')->nullable();
            // invoice  number
            $table->string('invoice_number')->nullable();
            $table->string('comment_id')->nullable();
            $table->json('order_items')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomplete');
    }
};
