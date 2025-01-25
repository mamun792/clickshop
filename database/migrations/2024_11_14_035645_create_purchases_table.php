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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_name');
            $table->date('purchase_date');
            $table->string('invoice_number')->unique();

            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');

            $table->string('document')->nullable(); // Nullable for optional documents
            $table->text('comment')->nullable(); // Nullable and changed to text for longer comments
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
