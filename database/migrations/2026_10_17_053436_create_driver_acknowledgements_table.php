<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('driver_acknowledgements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('driver_id')
                ->constrained('drivers')
                ->cascadeOnDelete();

            $table->text('message');

            $table->string('critical_level', 20)->default('normal');

            $table->timestamps();

            $table->index(['driver_id', 'critical_level']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('driver_acknowledgements');
    }
};