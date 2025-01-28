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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date');
            $table->foreignId('purpose_id')
                ->constrained('purposes')
                ->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->text('comments')->nullable();
            $table->foreignId('account_id')
                ->constrained('account_types')
                ->onDelete('restrict');
            $table->string('transaction_type', 10);
            $table->string('document')->nullable();
            $table->timestamps();

            $table->index('transaction_date');
            $table->index('purpose_id');
            $table->index('account_id');
            $table->index('transaction_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
