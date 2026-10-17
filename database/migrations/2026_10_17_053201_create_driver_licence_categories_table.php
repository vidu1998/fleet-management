<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('driver_licence_categories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('driver_id')
                ->constrained('drivers')
                ->cascadeOnDelete();

            $table->string('licence_category', 20);
            $table->date('expiry_date')->nullable();
            $table->date('receive_date')->nullable();

            $table->timestamps();

            $table->index(['driver_id', 'expiry_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('driver_licence_categories');
    }
};