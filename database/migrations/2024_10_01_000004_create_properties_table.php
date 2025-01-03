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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('rental_commune');
            $table->string('rental_address');
            $table->string('street_num');
            $table->string('int_num')->nullable(true);
            $table->string('floor')->nullable(true);
            $table->integer('user_id');
            $table->integer('status')->default(0)->nullable(true); // 0-inactive, 1-active
            $table->boolean('is_deleted')->default(0);
            $table->dateTime('deleted_at')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
