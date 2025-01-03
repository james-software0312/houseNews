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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('user_id');
            $table->integer('declarant_id')->nullable(true);
            $table->integer('property_id')->nullable(true);
            $table->string('owner_first_name')->nullable(true);
            $table->string('owner_last_name')->nullable(true);
            $table->date('owner_birthday')->nullable(true);
            $table->string('owner_birth_city')->nullable(true);
            $table->string('owner_birth_country')->nullable(true);
            $table->string('owner_address')->nullable(true);
            $table->string('owner_pec_email')->nullable(true);
            $table->string('owner_avatar')->nullable(true);
            $table->date('start_date')->nullable(true);
            $table->date('end_date')->nullable(true);
            $table->string('rental_commune')->nullable(true);
            $table->string('rental_address')->nullable(true);
            $table->string('street_num')->nullable(true);
            $table->string('int_num')->nullable(true);
            $table->string('floor')->nullable(true);
            $table->string('guest_email')->nullable(true);
            $table->string('pdf_filename')->nullable(true);
            $table->integer('status')->default(0); // 0-pending, 1-sent, 2-started, 3-finished, 4 : Canceled
            $table->boolean('is_deleted')->default(0);
            $table->dateTime('deleted_at')->nullable(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
