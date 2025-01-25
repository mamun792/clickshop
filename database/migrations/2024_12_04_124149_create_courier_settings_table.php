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
        Schema::create('courier_settings', function (Blueprint $table) {
            $table->id();
            $table->string('api_key')->nullable();
            $table->string('secret_key')->nullable();



            $table->string('redx_sandbox')->default('https://openapi.redx.com.bd/v1.0.0-beta');
            $table->string('redx_access_token')->nullable();

            $table->enum('steadfast', ['yes', 'no'])->default('no');
            $table->enum('redx', ['yes', 'no'])->default('no');
            $table->enum('pathao', ['yes', 'no'])->default('no');


           // $table->enum('is_active', ['steadfast', 'pathao', 'redx'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courier_settings');
    }
};
