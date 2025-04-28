<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Administrator',
                'deletable' => false,
                'default' => true,
                'organization_id' => 1,
            ],
            [
                'name' => 'admin_tenant',
                'description' => 'Tenant Administrator',
                'deletable' => false,
                'default' => true,
                'organization_id' => 1,
            ],
            [
                'name' => 'qa_manager',
                'description' => 'QA Manager',
                'deletable' => false,
                'default' => true,
                'organization_id' => 1,
            ],
            [
                'name' => 'qa_tester',
                'description' => 'QA Staff',
                'deletable' => false,
                'default' => true,
                'organization_id' => 1,
            ],
            [
                'name' => 'developer',
                'description' => 'Developer',
                'deletable' => false,
                'default' => true,
                'organization_id' => 1,
            ],
            [
                'name' => 'guest',
                'description' => 'Guest',
                'deletable' => false,
                'default' => true,
                'organization_id' => 1,
            ],
        ];

        // Create roles first
        foreach ($roles as $roleData) {
            Role::create($roleData);
        }

        // Now assign permissions to each role
        $this->assignAdminPermissions();
        $this->assignAdminTenantPermissions();
        $this->assignQaManagerPermissions();
        $this->assignQaTesterPermissions();
        $this->assignDeveloperPermissions();
        $this->assignGuestPermissions();
    }

    protected function assignAdminPermissions()
    {
        $role = Role::where('name', 'admin')->first();
        $role->permissions()->sync(Permission::pluck('id')->toArray());
    }

    protected function assignAdminTenantPermissions()
    {
        $role = Role::where('name', 'admin_tenant')->first();
        $permissions = Permission::whereIn('slug', [
            // Project
            'create-project', 'view-project', 'edit-project', 'delete-project',
            'archive-project', 'view-archived-project', 'edit-archived-project',

            // Team
            'view-team',

            // Build
            'create-build', 'view-build', 'edit-build', 'delete-build',

            // Modules
            'create-module', 'view-module', 'edit-module', 'delete-module',

            // Requirements
            'create-requirement', 'view-requirement', 'edit-requirement', 'delete-requirement',

            // Test Management
            'create-test-scenario', 'view-test-scenario', 'edit-test-scenario', 'delete-test-scenario',
            'create-test-case', 'view-test-case', 'edit-test-case', 'delete-test-case',
            'approve-test-case', 'execute-approved-test-case',
            'create-test-cycle', 'view-test-cycle', 'edit-test-cycle', 'delete-test-cycle',
            'view-manage-test-case', 'edit-manage-test-case',
            'create-test-case-execution', 'view-test-case-execution', 'edit-test-case-execution', 'delete-test-case-execution',

            // Defects
            'create-defect', 'view-defect', 'edit-defect', 'delete-defect',

            // Reports
            'create-defect-report', 'create-test-report'
        ])->pluck('id')->toArray();

        $role->permissions()->sync($permissions);
    }

    protected function assignQaManagerPermissions()
    {
        $role = Role::where('name', 'qa_manager')->first();
        $permissions = Permission::whereIn('slug', [
            // Project
            'view-project',

            // Test Management
            'create-test-scenario', 'view-test-scenario', 'edit-test-scenario', 'delete-test-scenario',
            'create-test-case', 'view-test-case', 'edit-test-case', 'delete-test-case',
            'approve-test-case', 'execute-approved-test-case',
            'create-test-cycle', 'view-test-cycle', 'edit-test-cycle', 'delete-test-cycle',
            'view-manage-test-case', 'edit-manage-test-case',
            'create-test-case-execution', 'view-test-case-execution', 'edit-test-case-execution', 'delete-test-case-execution',

            // Defects
            'create-defect', 'view-defect', 'edit-defect', 'delete-defect',

            // Reports
            'create-defect-report', 'create-test-report'
        ])->pluck('id')->toArray();

        $role->permissions()->sync($permissions);
    }

    protected function assignQaTesterPermissions()
    {
        $role = Role::where('name', 'qa_tester')->first();
        $permissions = Permission::whereIn('slug', [
            // Project
            'view-project',

            // Test Management
            'view-test-scenario',
            'view-test-case', 'execute-approved-test-case',
            'view-test-cycle',
            'view-manage-test-case',
            'create-test-case-execution', 'view-test-case-execution', 'edit-test-case-execution',

            // Defects
            'create-defect', 'view-defect', 'edit-defect'
        ])->pluck('id')->toArray();

        $role->permissions()->sync($permissions);
    }

    protected function assignDeveloperPermissions()
    {
        $role = Role::where('name', 'developer')->first();
        $permissions = Permission::whereIn('slug', [
            // Project
            'view-project',

            // Build
            'create-build', 'view-build', 'edit-build', 'delete-build',

            // Requirements
            'view-requirement',

            // Defects
            'view-defect', 'edit-defect'
        ])->pluck('id')->toArray();

        $role->permissions()->sync($permissions);
    }

    protected function assignGuestPermissions()
    {
        $role = Role::where('name', 'guest')->first();
        $permissions = Permission::whereIn('slug', [
            // Limited view-only permissions
            'view-project',
            'view-build',
            'view-module',
            'view-requirement'
        ])->pluck('id')->toArray();

        $role->permissions()->sync($permissions);
    }
}
