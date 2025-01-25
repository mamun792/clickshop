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


        Schema::create('product_attribute_combinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->longText('combination_string');
          
            $table->timestamps();
        });

        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('attribute_id');
            $table->integer('attribute_option_id');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->integer('sold_quantity')->default(0);
            // enum typle enable or disable
            $table->enum('status', ['enable', 'disable'])->default('enable');
            $table->foreignId('combination_id')->nullable()
            ->constrained('product_attribute_combinations')
            ->onDelete('cascade');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attributes');
    }
};
