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
            $table->string('product_name')->index();
            $table->string('product_code')->unique()->index();
            $table->text('short_description');
            $table->longtext('description')->nullable();
            $table->json('product_tag')->nullable();
            $table->json('specification')->nullable();
            // $table->json('attributes')->nullable();
            $table->enum('stock_option', ['Manual', 'From Purchase'])->default('Manual');
            $table->unsignedInteger('quantity');
            $table->decimal('price', 10, 2);
            $table->decimal('previous_price', 10, 2)->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('subcategory_id');
            $table->string('brand_id')->nullable();

            $table->string('featured_image');
            $table->json('gallery_images')->nullable();

            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->enum('feature', ['New Arrival', 'None'])->default('New Arrival');
            $table->enum('status', ['Published', 'Unpublished'])->default('Published');
            $table->string('slug')->nullable();
            $table->integer('sold_quantity')->default(0);
            $table->boolean('is_free_shipping')->default(0);
            $table->text('note')->nullable();
            $table->unsignedBigInteger('purchase_id')->nullable();
            $table->timestamps();


            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->foreign('subcategory_id')->references('id')->on('sub_categories')->onDelete('cascade');

          //  $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');

            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('set null');




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
