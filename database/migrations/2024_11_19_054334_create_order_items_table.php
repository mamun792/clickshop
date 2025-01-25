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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // Foreign keys with cascade on update and delete for consistency
            $table->foreignId('order_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade')->onUpdate('cascade');

            // Product quantity and price
            $table->integer('quantity');
            $table->decimal('price', 10, 2);

            // Coupon and campaign details
            $table->foreignId('coupon_id')->nullable()->constrained()->onDelete('set null')->onUpdate('cascade');
            $table->string('code')->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->enum('discount_type', ['fixed', 'percent'])->nullable();

            // Campaign related to the item
            $table->foreignId('campaign_id')->nullable()->constrained()->onDelete('set null')->onUpdate('cascade');

            $table->timestamps();

            // Composite index for order_id + product_id
            $table->index(['order_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
