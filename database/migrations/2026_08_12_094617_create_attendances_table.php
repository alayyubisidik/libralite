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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete()
                ->cascadeOnUpdate()
                ->comment('Member (users.id)');
            $table->date('check_in_date');
            $table->time('check_in_time');
            $table->enum('status', ['present'])->default('present');
            $table->timestamps();

            $table->unique(['user_id', 'check_in_date'], 'unique_user_checkin_per_day');
            $table->index('check_in_date', 'idx_attendances_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};