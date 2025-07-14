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
        Schema::create('shop_owner_infos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('shopName');
            $table->string('shopPhone');
            $table->longText('shopAddress');
            $table->string('shopLong');
            $table->string('shopLat');
            $table->longText('shopDescription');
            $table->string('permit');
            $table->string('permitNumber');
            $table->string('expiration');
            $table->timestamps();
            // relation to user id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_owner_infos');
    }
};
