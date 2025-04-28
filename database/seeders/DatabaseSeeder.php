<?php

namespace Database\Seeders;

use App\Models\Organization;
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
        Organization::create([
            'name' => 'QA Ignite'
        ]);

        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
    }
}
