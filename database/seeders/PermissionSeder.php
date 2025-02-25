<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Project Management
            [
                'name' => 'create project',
            ],
            [
                'name' => 'view project',
            ],
            [
                'name' => 'edit project',
            ],
            [
                'name' => 'delete project',
            ],

            // Archive Projects
            [
                'name' => 'view archive project',
            ],
            [
                'name' => 'edit archive project',
            ],

            //Team Management
            [
                'name' => 'create team',
            ],
            [
                'name' => 'view team',
            ],
            [
                'name' => 'edit team',
            ],
            [
                'name' => 'delete team',
            ],

            // Build Management
            [
                'name' => 'create build',
            ],
            [
                'name' => 'view build',
            ],
            [
                'name' => 'edit build',
            ],
            [
                'name' => 'delete build',
            ],

            // Module Management
            [
                'name' => 'create module',
            ],
            [
                'name' => 'view module',
            ],
            [
                'name' => 'edit module',
            ],
            [
                'name' => 'delete module',
            ],

            // Requirement Management
            [
                'name' => 'create requirement',
            ],
            [
                'name' => 'view requirement',
            ],
            [
                'name' => 'edit requirement',
            ],
            [
                'name' => 'delete requirement',
            ],

            // Test Scenario Management
            [
                'name' => 'create test scenario',
            ],
            [
                'name' => 'view test scenario',
            ],
            [
                'name' => 'edit test scenario',
            ],
            [
                'name' => 'delete test scenario',
            ],

            // Test Case Management
            [
                'name' => 'create test case',
            ],
            [
                'name' => 'view test case',
            ],
            [
                'name' => 'edit test case',
            ],
            [
                'name' => 'delete test case',
            ],
            [
                'name' => 'approve test case',
            ],
            [
                'name' => 'execute test case',
            ],

            // Test Plan Management
            [
                'name' => 'create test plan',
            ],
            [
                'name' => 'view test plan',
            ],
            [
                'name' => 'edit test plan',
            ],
            [
                'name' => 'delete test plan',
            ],

            // Test Cycle Management
            [
                'name' => 'create test cycle',
            ],
            [
                'name' => 'view test cycle',
            ],
            [
                'name' => 'edit test cycle',
            ],
            [
                'name' => 'delete test cycle',
            ],

            // Test Case Execution
            [
                'name' => 'create test case execution',
            ],
            [
                'name' => 'view test case execution',
            ],
            [
                'name' => 'edit test case execution',
            ],
            [
                'name' => 'delete test case execution',
            ],

            // Defect Management
            [
                'name' => 'create defect',
            ],
            [
                'name' => 'view defect',
            ],
            [
                'name' => 'edit defect',
            ],
            [
                'name' => 'delete defect',
            ],
            [
                'name' => 'approve defect',
            ],
            [
                'name' => 'reject defect',
            ],

            // Defect Report
            [
                'name' => 'view defect report',
            ],

            // Test Reports
            [
                'name' => 'view test report',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
