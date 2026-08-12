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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete()
                ->cascadeOnUpdate()
                ->comment('Member (users.id)');
            $table->foreignId('book_id')
                ->constrained('books')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('processed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->cascadeOnUpdate()
                ->comment('Admin (users.id) who processed the return');
            $table->string('borrow_code')->unique();
            $table->date('borrow_date');
            $table->date('due_date');
            $table->dateTime('returned_at')->nullable();
            $table->enum('status', ['borrowed', 'returned', 'overdue'])->default('borrowed');
            $table->timestamps();

            $table->index('status', 'idx_borrowings_status');
            $table->index(['user_id', 'status'], 'idx_borrowings_user_status');
            $table->index('due_date', 'idx_borrowings_due_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};