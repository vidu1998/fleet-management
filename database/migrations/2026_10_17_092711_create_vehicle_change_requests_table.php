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
    Schema::create('vehicle_change_requests', function (Blueprint $table) {
        $table->id();

        $table->foreignId('vehicle_id')
            ->nullable()
            ->constrained('vehicles')
            ->nullOnDelete();

        $table->foreignId('maker_id')
            ->constrained('users')
            ->restrictOnDelete();

        $table->foreignId('checker_id')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

        $table->string('action', 20);
        $table->json('payload');
        $table->string('status', 20)->default('pending');
        $table->text('checker_comment')->nullable();
        $table->timestamp('submitted_at')->nullable();
        $table->timestamp('reviewed_at')->nullable();

        $table->timestamps();
        $table->index(['status', 'submitted_at']);
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_change_requests');
    }
};
