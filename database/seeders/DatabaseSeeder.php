<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        $this->call([
            UsersTableSeeder::class
        ]);

        // User::factory()->create([
        //     'first_name' => 'Test',
        //     'last_name' => 'user',
        //     'email' => 'test@example.com',
        //     'password' => Hash::make('password'),
        // ]);
    }
}
