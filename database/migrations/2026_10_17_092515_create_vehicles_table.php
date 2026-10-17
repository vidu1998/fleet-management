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
    Schema::create('vehicles', function (Blueprint $table) {
        $table->id();

        $table->string('registration_no')->unique();
        $table->string('make');
        $table->unsignedSmallInteger('manufacture_year');

        $table->string('type', 30);
        $table->string('fuel_type', 20);
        $table->string('color', 50)->nullable();

        $table->date('purchased_date')->nullable();
        $table->decimal('purchased_price', 14, 2)->nullable();

        $table->date('insurance_expire_date')->nullable();
        $table->date('road_tax_expire_date')->nullable();

        $table->decimal('current_odo_reading', 12, 2)->default(0);

        $table->unsignedTinyInteger('engine_condition_percentage')
            ->default(100);

        $table->unsignedTinyInteger('body_condition_percentage')
            ->default(100);

        $table->string('current_location')->nullable();
        $table->string('parking_location')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
