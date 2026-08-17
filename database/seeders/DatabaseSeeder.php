<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


       $user = User::updateOrCreate(
            ['email' => 'test@example.com'], 
            ['name' => 'Test User']            // Values to create or update
        );

        $this->call(DemoDataSeeder::class);
    }
}
