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
        Schema::create('task_details', function (Blueprint $table) {
            $table->id();
            $table->integer('task_id');
            $table->string('token')->nullable();
            $table->string('guest_email');
            $table->string('guest_first_name')->nullable();
            $table->string('guest_last_name')->nullable();
            $table->date('guest_birthday')->nullable();
            $table->string('guest_birth_city')->nullable();
            $table->string('guest_birth_country')->nullable();
            $table->string('guest_nationality')->nullable();
            $table->string('guest_address')->nullable();
            $table->string('id_type')->nullable();
            $table->string('id_num')->nullable();
            $table->date('id_date')->nullable();
            $table->string('id_authority')->nullable();
            $table->string('passport')->nullable();
            $table->string('guest_message')->nullable();
            $table->integer('status')->default(0); // 0-pending, 1-opened, 2-sent
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_details');
    }
};
