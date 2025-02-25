<?php

namespace Database\Seeders;

use App\Models\RoleHasPermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 52; $i++) {
            RoleHasPermission::create(
                [
                    'role_id' => 2,
                    'permission_id' => $i
                ]
            );
        }

        // For QA Manager
        for ($i = 19; $i <= 52; $i++) {
            RoleHasPermission::create(
                [
                    'role_id' => 3,
                    'permission_id' => $i
                ]
            );
        }
    }
}
