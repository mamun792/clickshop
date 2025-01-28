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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_account_id')->constrained('account_types')->onDelete('cascade');
            $table->foreignId('to_account_id')->constrained('account_types')->onDelete('cascade');

            $table->decimal('transfer_amount', 15, 2);
            $table->date('transfer_date');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->text('comments')->nullable();

            $table->string('transaction_type');
            $table->double('cost', 15, 2);



            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
