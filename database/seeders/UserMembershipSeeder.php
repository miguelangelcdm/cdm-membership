<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserMembership;

class UserMembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserMembership::factory(3)->create();
    }
}
