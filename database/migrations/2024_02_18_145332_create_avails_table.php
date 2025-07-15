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
        Schema::create('avails', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('shop_id');
            $table->uuid('service_id');
            $table->uuid('user_id');
            $table->string('shop_name');
            $table->string('service_name');
            $table->string('service_price');
            $table->text('service_description')->nullable();
            $table->string('last_odometer_reading');
            $table->text('notes')->nullable();
            $table->string('arrival');
            $table->integer(column: 'service_old_price')->nullable();
            $table->integer(column: 'service_new_price')->nullable();
            $table->string(column: 'service_price_notes')->nullable();

            $table->enum('status', ['Rejected', 'Approved', 'Pending', 'Paid'])->default('Pending');

            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avails');
    }
};
