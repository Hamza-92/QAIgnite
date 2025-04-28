<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // Project Permissions
            ['name' => 'Create Project', 'slug' => 'create-project', 'description' => 'Can create new projects'],
            ['name' => 'View Project', 'slug' => 'view-project', 'description' => 'Can view projects'],
            ['name' => 'Edit Project', 'slug' => 'edit-project', 'description' => 'Can edit projects'],
            ['name' => 'Delete Project', 'slug' => 'delete-project', 'description' => 'Can delete projects'],
            ['name' => 'Archive Project', 'slug' => 'archive-project', 'description' => 'Can archive projects'],
            ['name' => 'View Archived Project', 'slug' => 'view-archived-project', 'description' => 'Can view archived projects'],
            ['name' => 'Edit Archived Project', 'slug' => 'edit-archived-project', 'description' => 'Can edit archived projects'],

            // Team Permissions
            ['name' => 'View Team', 'slug' => 'view-team', 'description' => 'Can view team members'],

            // Build Permissions
            ['name' => 'Create Build', 'slug' => 'create-build', 'description' => 'Can create new builds'],
            ['name' => 'View Build', 'slug' => 'view-build', 'description' => 'Can view builds'],
            ['name' => 'Edit Build', 'slug' => 'edit-build', 'description' => 'Can edit builds'],
            ['name' => 'Delete Build', 'slug' => 'delete-build', 'description' => 'Can delete builds'],

            // Module Permissions
            ['name' => 'Create Module', 'slug' => 'create-module', 'description' => 'Can create new modules'],
            ['name' => 'View Module', 'slug' => 'view-module', 'description' => 'Can view modules'],
            ['name' => 'Edit Module', 'slug' => 'edit-module', 'description' => 'Can edit modules'],
            ['name' => 'Delete Module', 'slug' => 'delete-module', 'description' => 'Can delete modules'],

            // Requirement Permissions
            ['name' => 'Create Requirement', 'slug' => 'create-requirement', 'description' => 'Can create new requirements'],
            ['name' => 'View Requirement', 'slug' => 'view-requirement', 'description' => 'Can view requirements'],
            ['name' => 'Edit Requirement', 'slug' => 'edit-requirement', 'description' => 'Can edit requirements'],
            ['name' => 'Delete Requirement', 'slug' => 'delete-requirement', 'description' => 'Can delete requirements'],

            // Test Scenario Permissions
            ['name' => 'Create Test Scenario', 'slug' => 'create-test-scenario', 'description' => 'Can create new test scenarios'],
            ['name' => 'View Test Scenario', 'slug' => 'view-test-scenario', 'description' => 'Can view test scenarios'],
            ['name' => 'Edit Test Scenario', 'slug' => 'edit-test-scenario', 'description' => 'Can edit test scenarios'],
            ['name' => 'Delete Test Scenario', 'slug' => 'delete-test-scenario', 'description' => 'Can delete test scenarios'],

            // Test Case Permissions
            ['name' => 'Create Test Case', 'slug' => 'create-test-case', 'description' => 'Can create new test cases'],
            ['name' => 'View Test Case', 'slug' => 'view-test-case', 'description' => 'Can view test cases'],
            ['name' => 'Edit Test Case', 'slug' => 'edit-test-case', 'description' => 'Can edit test cases'],
            ['name' => 'Delete Test Case', 'slug' => 'delete-test-case', 'description' => 'Can delete test cases'],
            ['name' => 'Approve Test Case', 'slug' => 'approve-test-case', 'description' => 'Can approve test cases'],
            ['name' => 'Execute Approved Test Case', 'slug' => 'execute-approved-test-case', 'description' => 'Can execute approved test cases'],

            // Test Cycle Permissions
            ['name' => 'Create Test Cycle', 'slug' => 'create-test-cycle', 'description' => 'Can create new test cycles'],
            ['name' => 'View Test Cycle', 'slug' => 'view-test-cycle', 'description' => 'Can view test cycles'],
            ['name' => 'Edit Test Cycle', 'slug' => 'edit-test-cycle', 'description' => 'Can edit test cycles'],
            ['name' => 'Delete Test Cycle', 'slug' => 'delete-test-cycle', 'description' => 'Can delete test cycles'],

            // Manage Test Case Permissions
            ['name' => 'View Manage Test Case', 'slug' => 'view-manage-test-case', 'description' => 'Can view test case management'],
            ['name' => 'Edit Manage Test Case', 'slug' => 'edit-manage-test-case', 'description' => 'Can edit test case management'],

            // Test Case Execution Permissions
            ['name' => 'Create Test Case Execution', 'slug' => 'create-test-case-execution', 'description' => 'Can create test case executions'],
            ['name' => 'View Test Case Execution', 'slug' => 'view-test-case-execution', 'description' => 'Can view test case executions'],
            ['name' => 'Edit Test Case Execution', 'slug' => 'edit-test-case-execution', 'description' => 'Can edit test case executions'],
            ['name' => 'Delete Test Case Execution', 'slug' => 'delete-test-case-execution', 'description' => 'Can delete test case executions'],

            // Defect Permissions
            ['name' => 'Create Defect', 'slug' => 'create-defect', 'description' => 'Can create new defects'],
            ['name' => 'View Defect', 'slug' => 'view-defect', 'description' => 'Can view defects'],
            ['name' => 'Edit Defect', 'slug' => 'edit-defect', 'description' => 'Can edit defects'],
            ['name' => 'Delete Defect', 'slug' => 'delete-defect', 'description' => 'Can delete defects'],

            // Report Permissions
            ['name' => 'Create Defect Report', 'slug' => 'create-defect-report', 'description' => 'Can create defect reports'],
            ['name' => 'Create Test Report', 'slug' => 'create-test-report', 'description' => 'Can create test reports'],

            // Admin Permissions
            ['name' => 'Admin Access', 'slug' => 'admin-access', 'description' => 'Full administrative access'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
