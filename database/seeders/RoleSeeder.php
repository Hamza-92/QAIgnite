<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Administrator',
                'deletable' => false,
                'default' => true,
                'organization_id' => 1,
                'permissions' => []
            ],
            [
                'name' => 'admin_tenant',
                'description' => 'Tenant Administrator',
                'deletable' => false,
                'default' => true,
                'organization_id' => 1,
                'permissions' => []
            ],
            [
                'name' => 'qa_manager',
                'description' => 'QA Manager',
                'deletable' => false,
                'default' => true,
                'organization_id' => 1,
                'permissions' => []
            ],
            [
                'name' => 'qa_tester',
                'description' => 'QA Staff',
                'deletable' => false,
                'default' => true,
                'organization_id' => 1,
                'permissions' => []
            ],
            [
                'name' => 'developer',
                'description' => 'Developer',
                'deletable' => false,
                'default' => true,
                'organization_id' => 1,
                'permissions' => []
            ],
            [
                'name' => 'guest',
                'description' => 'Guest',
                'deletable' => false,
                'default' => true,
                'organization_id' => 1,
                'permissions' => []
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
