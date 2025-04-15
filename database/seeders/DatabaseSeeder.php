<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\MembershipSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\UserMembershipSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            // 'name' => 'Test User',
            // 'email' => 'test@example.com',
            RoleSeeder::class,
            MembershipSeeder::class,
            UserSeeder::class,
            UserMembershipSeeder::class,
        ]);
    }
}
