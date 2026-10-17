<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('licence_file_path')->nullable();

            $table->string('phone', 20)->nullable()->unique();
            $table->string('email')->nullable()->unique();

            $table->decimal('drive_mileage', 12, 2)->default(0);

            $table->string('blood_group', 5)->nullable();
            $table->boolean('is_smoker')->default(false);
            $table->boolean('is_drinker')->default(false);

            $table->text('address')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};