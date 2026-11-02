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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();

            // pricing
            $table->decimal('price', 10, 2)->nullable();
            $table->string('currency', 10)->default('USD');

            // plan nature
            $table->enum('type', ['subscription', 'one_time']);
            $table->string('interval')->nullable();

            // PayPal mapping
            $table->string('paypal_product_id')->nullable();
            $table->string('paypal_plan_id')->nullable();

            $table->enum('status', ['Active', 'Inactive'])->default('Active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
