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
        Schema::create('declarants', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('pec_email')->nullable();
            $table->string('pec_password')->nullable();
            $table->date('birthday')->nullable();
            $table->string('birth_city')->nullable();
            $table->string('birth_country')->nullable();
            $table->string('nationality')->nullable();
            $table->string('address')->nullable();
            $table->string('avatar')->nullable();
            $table->integer('user_id');
            $table->boolean('is_owned')->default(0);
            $table->integer('status')->default(0)->nullable(true);
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
        Schema::dropIfExists('declarants');
    }
};
