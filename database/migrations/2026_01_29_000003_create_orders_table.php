<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained()->onDelete('cascade');
            $table->foreignId('config_id')->nullable()->constrained()->onDelete('set null');
            $table->string('payment_order_id')->nullable(); // HarakaPay order_id
            $table->string('payment_phone')->nullable(); // Phone used for payment
            $table->decimal('amount', 10, 2);
            $table->decimal('net_amount', 10, 2)->nullable();
            $table->decimal('fee_amount', 10, 2)->nullable();
            $table->enum('payment_status', ['pending', 'processing', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->enum('order_status', ['pending', 'paid', 'delivered', 'cancelled'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'order_status']);
            $table->index('payment_order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
