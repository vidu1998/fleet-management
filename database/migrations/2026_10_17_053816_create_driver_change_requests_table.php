<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('driver_change_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('driver_id')
                ->nullable()
                ->constrained('drivers')
                ->nullOnDelete();

            $table->foreignId('maker_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('checker_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('action', 20); // create or update
            $table->json('payload');

            $table->string('status', 20)->default('pending');
            $table->text('checker_comment')->nullable();

            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['maker_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('driver_change_requests');
    }
};