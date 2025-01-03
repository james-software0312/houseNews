<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    User::factory()->create([
      'first_name' => 'Richard',
      'last_name' => 'Greenbury',
      'email' => 'admin@cribmed.com',
      'is_admin' => 1,
      'status' => 1,
      'is_verified' => 1,
    ]);

    // User::factory(10)->create();
  }
}
