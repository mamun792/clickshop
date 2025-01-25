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
        Schema::create('cart_attributes', function (Blueprint $table) {
            $table->id();
          
           
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('attribute_options_id')->nullable();
            $table->unsignedBigInteger('product_attr_id')->nullable();
            
            $table->timestamps();

            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            
            $table->unique(['cart_id', 'attribute_options_id'], 'unique_cart_attribute');
          
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_attributes');
    }
};
