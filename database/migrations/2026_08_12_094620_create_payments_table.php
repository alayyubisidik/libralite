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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fine_id')
                ->constrained('fines')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete()
                ->cascadeOnUpdate()
                ->comment('Member (users.id)');
            $table->string('order_id')->unique()
                ->comment('Unique order/transaction ID sent to Midtrans');
            $table->string('transaction_id')->nullable()
                ->comment('Midtrans transaction_id from notification payload');
            $table->string('provider')->default('midtrans');
            $table->string('payment_type')->nullable()
                ->comment('e.g. bank_transfer, gopay, credit_card');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'paid', 'failed', 'expired', 'cancelled'])->default('pending');
            $table->dateTime('paid_at')->nullable();
            $table->json('raw_response')->nullable()->comment('Raw Midtrans notification payload, for audit/verification');
            $table->timestamps();

            $table->index('status', 'idx_payments_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};