<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // default user for testing
        User::create([
            'name'=>'test user',
            "email"=> "test@example.com",
            "password"=> bcrypt("12345@@")
        ]);

        // Users dumy data
        User::factory()->count(10)->create();
    }
}
