<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Membership;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $memberships = [
            ['name' => 'Menor', 'price' => 9.99, 'duration' => 30],
            ['name' => 'Mayor', 'price' => 19.99, 'duration' => 90],
            ['name' => 'Vitalicio', 'price' => 49.99, 'duration' => 365],
        ];
        // DB::table('memberships')->insert($memberships);
        foreach ($memberships as $membership) {
            Membership::create($membership);
        }
    }
}
