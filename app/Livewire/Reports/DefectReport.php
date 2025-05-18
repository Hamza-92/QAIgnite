<?php

namespace App\Livewire\Reports;

use App\Exports\ReportExport;
use App\Models\Build;
use App\Models\Defect;
use App\Models\Module;
use App\Models\Requirement;
use App\Models\TestCase;
use App\Models\TestScenario;
use App\Models\User;
use App\Services\PdfReportGenerator;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Livewire\WithPagination;
use PhpOffice\PhpWord\PhpWord;

class DefectReport extends Component
{
    use WithPagination;
    public $reportColumns;
    public $defects;
    public function mount()
    {
        $this->reportColumns = ['id', 'def_name'];
        $this->updateBuildsList();
        $this->updateModulesList();
        $this->updateRequirementsList();
        $this->updateTestScenariosList();
        $this->updateTestCasesList();

        $this->getCreatedByUsers();
        $this->getAssignedToUsers();
    }
    // Filter: build field data handling
    public $builds;
    public $build_id;
    public function updatedBuildId()
    {
        if ($this->build_id == 'all') {
            $this->build_id = null;
        }
        $this->updateModulesList();
    }
    public function updateBuildsList()
    {
        $this->builds = Build::where('project_id', auth()->user()->default_project)
            ->get(['id', 'name']);

        // Reset dependent fields
        $this->build_id = null;
        $this->updateModulesList();
    }

    // Filter: module field data handling
    public $modules;
    public $module_id;
    public function updatedModuleId()
    {
        if ($this->module_id == 'all') {
            $this->module_id = null;
        }
        $this->updateRequirementsList();
    }
    public function updateModulesList()
    {
        $this->modules = Module::where('project_id', auth()->user()->default_project)
            ->where('build_id', $this->build_id)
            ->get(['id', 'module_name']);

        // Reset dependent field
        $this->module_id = null;
        $this->updateRequirementsList();
    }

    // Filter: requirement field data handling
    public $requirements;
    public $requirement_id;
    public function updatedRequirementId()
    {
        if ($this->requirement_id == 'all') {
            $this->requirement_id = null;
        }
        $this->updateTestScenariosList();
    }
    public function updateRequirementsList()
    {
        $this->requirements = Requirement::where('project_id', auth()->user()->default_project)
            ->where('build_id', $this->build_id)
            ->where('module_id', $this->module_id)
            ->get(['id', 'requirement_title']);

        $this->requirement_id = null;
        $this->updateTestScenariosList();
    }
    // Filter: test scenario field data handling
    public $test_scenarios;
    public $test_scenario_id;
    public function updatedTestScenarioId()
    {
        if ($this->test_scenario_id == 'all') {
            $this->test_scenario_id = null;
        }
        $this->updateTestCasesList();
        $this->resetPage();
    }
    public function updateTestScenariosList()
    {
        $this->test_scenarios = TestScenario::where('ts_project_id', auth()->user()->default_project)
            ->where('ts_build_id', $this->build_id)
            ->where('ts_module_id', $this->module_id)
            ->where('ts_requirement_id', $this->requirement_id)
            ->get(['id', 'ts_name']);

        $this->test_scenario_id = null;

        $this->updateTestCasesList();
    }
    // Filter: test case field data handling
    public $test_cases;
    public $test_case_id;
    public function updatedTestCaseId()
    {
        if ($this->test_case_id == 'all') {
            $this->test_case_id = null;
        }
        $this->resetPage();
    }
    public function updateTestCasesList()
    {
        $this->test_cases = TestCase::where('tc_project_id', auth()->user()->default_project)
            ->where('tc_build_id', $this->build_id)
            ->where('tc_module_id', $this->module_id)
            ->where('tc_requirement_id', $this->requirement_id)
            ->where('tc_test_scenario_id', $this->test_scenario_id)
            ->get(['id', 'tc_name']);

        $this->test_case_id = null;
    }

    // Filter: defect type field data handling
    public $defect_type;
    public function updatedDefectType()
    {
        if ($this->defect_type == 'all') {
            $this->defect_type = null;
        }
        $this->resetPage();
    }

    // Filter: status field data handling
    public $defect_status;
    public function updatedDefectStatus()
    {
        if ($this->defect_status == 'all') {
            $this->defect_status = null;
        }
        $this->resetPage();
    }

    // Filter: severity field data handling
    public $defect_severity;
    public function updatedDefectSeverity()
    {
        if ($this->defect_severity == 'all') {
            $this->defect_severity = null;
        }
        $this->resetPage();
    }

    // Filter: priority field data handling
    public $defect_priority;
    public function updatedDefectPriority()
    {
        if ($this->defect_priority == 'all') {
            $this->defect_priority = null;
        }
        $this->resetPage();
    }

    // Filter: defect environment field data handling
    public $defect_environment;
    public function updatedDefectEnvironment()
    {
        if ($this->defect_environment == 'all') {
            $this->defect_environment = null;
        }
        $this->resetPage();
    }

    // Filter: created_by field data handling
    public $created_by_users;
    public $created_by;
    public function updatedCreatedBy()
    {
        if ($this->created_by == 'all') {
            $this->created_by = null;
        }
        $this->resetPage();
    }
    public function getCreatedByUsers()
    {
        $this->created_by_users = User::whereHas('created_defects', function ($query) {
            $query->where('def_project_id', auth()->user()->default_project);
        })
            ->select('id', 'username')
            ->distinct()
            ->get();
    }

    // Filter: assigned_to field data handling
    public $assigned_to_users;
    public $assigned_to;
    public function updatedAssignedTo()
    {
        if ($this->assigned_to == 'all') {
            $this->assigned_to = null;
        }
        $this->resetPage();
    }
    public function getAssignedToUsers()
    {
        $this->assigned_to_users = User::whereHas('assigned_defects', function ($query) {
            $query->where('def_project_id', auth()->user()->default_project);
        })
            ->select('id', 'username')
            ->distinct()
            ->get();
    }

    public function clearFilter()
    {
        $this->build_id = null;
        $this->module_id = null;
        $this->requirement_id = null;
        $this->test_scenario_id = null;
        $this->test_case_id = null;
        $this->defect_type = null;
        $this->defect_status = null;
        $this->defect_severity = null;
        $this->defect_priority = null;
        $this->defect_environment = null;
        $this->created_by = null;
        $this->assigned_to = null;

        // Reset search and pagination
        $this->search = '';
        $this->resetPage();
    }

    public $sortBy = 'created_at';
    public $sortDir = 'DESC';
    public $perPage = 20;

    // Table controller methods
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function setSortBy($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'ASC';
        }
    }

    public function getSortColumn()
    {
        return $this->sortBy;
    }

    public function generateReport()
    {
        $query = $this->getBaseQuery();

        $this->defects = $query->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage)
            ->map(function ($defect) {
                return $this->mapDefectData($defect, false); // false for not download
            });

        $this->resetPage();
    }

    protected function getBaseQuery()
    {
        return Defect::with([
            'requirement:id,requirement_title',
            'assignedTo:id,username',
            'createdBy:id,username'
        ])
            ->where('def_project_id', auth()->user()->default_project)
            ->when($this->build_id, function ($query) {
                $query->where('def_build_id', $this->build_id);
            })
            ->when($this->module_id, function ($query) {
                $query->where('def_module_id', $this->module_id);
            })
            ->when($this->requirement_id, function ($query) {
                $query->where('def_requirement_id', $this->requirement_id);
            })
            ->when($this->test_scenario_id, function ($query) {
                $query->where('def_test_scenario_id', $this->test_scenario_id);
            })
            ->when($this->test_case_id, function ($query) {
                $query->where('def_test_case_id', $this->test_case_id);
            })
            ->when($this->defect_type, function ($query) {
                $query->where('def_type', $this->defect_type);
            })
            ->when($this->defect_status, function ($query) {
                $query->where('def_status', $this->defect_status);
            })
            ->when($this->defect_severity, function ($query) {
                $query->where('def_severity', $this->defect_severity);
            })
            ->when($this->defect_priority, function ($query) {
                $query->where('def_priority', $this->defect_priority);
            })
            ->when($this->defect_environment, function ($query) {
                $query->where('def_environment', $this->defect_environment);
            })
            ->when($this->created_by, function ($query) {
                $query->where('def_created_by', $this->created_by);
            })
            ->when($this->assigned_to, function ($query) {
                $query->where('def_assigned_to', $this->assigned_to);
            });
    }

    protected function mapDefectData($defect, $forDownload = false)
    {
        $mappedDefect = [];

        foreach ($this->reportColumns as $column) {
            if ($column === 'def_requirement_id') {
                $mappedDefect['requirement_title'] = $defect->requirement->requirement_title ?? null;
                if (! $forDownload) {
                    $defect->requirement_title = $mappedDefect['requirement_title'];
                }
                unset($defect->def_requirement_id);
            } elseif ($column === 'def_assigned_to') {
                $mappedDefect['assigned_user'] = $defect->assignedTo->username ?? null;
                if (! $forDownload) {
                    $defect->assigned_user = $mappedDefect['assigned_user'];
                }
                unset($defect->def_assigned_to);
            } elseif ($column === 'def_created_by') {
                $mappedDefect['created_user'] = $defect->createdBy->username ?? null;
                if (! $forDownload) {
                    $defect->created_user = $mappedDefect['created_user'];
                }
                unset($defect->def_created_by);
            } elseif ($column === 'updated_at' && $defect->def_status === 'close') {
                $mappedDefect['closure_date'] = $defect->updated_at;
                if (! $forDownload) {
                    $defect->closure_date = $mappedDefect['closure_date'];
                }
            } else {
                $mappedDefect[$column] = $defect->$column;
                if (! $forDownload) {
                    $defect->$column = $mappedDefect[$column];
                }
            }
        }

        if (! $forDownload) {
            unset($defect->requirement, $defect->assignedTo, $defect->createdBy);
            return $defect;
        }

        return $mappedDefect;
    }

    protected function prepareDownloadData()
    {
        $query = $this->getBaseQuery();

        return $query->orderBy($this->sortBy, $this->sortDir)
            ->get()
            ->map(function ($defect) {
                return $this->mapDefectData($defect, false);
            })
            ->toArray();
    }

    protected function getReportHeaders()
    {
        return array_map(function ($column) {
            switch ($column) {
                case 'def_name':
                    return 'Defect ID';
                case 'def_description':
                    return 'Description';
                case 'def_status':
                    return 'Status';
                case 'def_type':
                    return 'Type';
                case 'def_priority':
                    return 'Priority';
                case 'def_severity':
                    return 'Severity';
                case 'def_environment':
                    return 'Environment';
                case 'def_steps_to_reproduce':
                    return 'Step to Reproduce';
                case 'def_expected_result':
                    return 'Expected Results';
                case 'def_actual_result':
                    return 'Actual Results';
                case 'def_requirement_id':
                    return 'Requirement';
                case 'def_assigned_to':
                    return 'Assigned User';
                case 'def_created_by':
                    return 'Created User';
                case 'created_at':
                    return 'Created Date';
                case 'updated_at':
                    return in_array('def_status', $this->reportColumns)
                        ? 'Closure Date'
                        : 'Updated Date';
                default:
                    return ucfirst(str_replace('_', ' ', $column));
            }
        }, $this->reportColumns);
    }

    public function downloadExcelReport()
    {
        $headers = $this->getReportHeaders();
        $data = $this->prepareDownloadData();

        return \Maatwebsite\Excel\Facades\Excel::download(
            new ReportExport($headers, $data),
            'defect-report.xlsx'
        );
    }

    public function downloadCsvReport()
    {
        $headers = $this->getReportHeaders();
        $data = $this->prepareDownloadData();

        return \Maatwebsite\Excel\Facades\Excel::download(
            new ReportExport($headers, $data),
            'defect-report.csv',
            \Maatwebsite\Excel\Excel::CSV
        );
    }

    public function downloadPdfReport()
    {
        $headers = $this->getReportHeaders();
        $data = $this->prepareDownloadData();
        $filename = 'Defect_Report_'.date('Y-m-d_H-i').'.pdf';

        return (new PdfReportGenerator())
            ->generate('Defect Report', $headers, $data, $this->reportColumns)
            ->download($filename);
    }

    public function downloadDocReport()
    {
        $headers = $this->getReportHeaders();
        $data = $this->prepareDownloadData();

        $phpWord = new PhpWord();
        $section = $phpWord->addSection([
            'marginLeft' => 600,    // 0.6 inches
            'marginRight' => 600,   // 0.6 inches
            'marginTop' => 900,     // 0.9 inches
            'marginBottom' => 900   // 0.9 inches
        ]);

        // Document title with improved styling
        $section->addText(
            'DEFECT REPORT',
            [
                'name' => 'Calibri',
                'size' => 18,
                'bold' => true,
                'color' => '2E74B5'
            ],
            [
                'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                'spaceAfter' => 400
            ]
        );

        // Add report generation date
        $section->addText(
            'Generated by: '.auth()->user()->username.' on '.date('F j, Y'),
            [
                'name' => 'Calibri',
                'size' => 10,
                'italic' => true,
                'color' => '7F7F7F'
            ],
            [
                'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                'spaceAfter' => 600
            ]
        );

        // Table styles with improved appearance
        $tableStyle = [
            'borderSize' => 4,
            'borderColor' => 'D3D3D3',
            'cellMargin' => 100,
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT
        ];

        $headerStyle = [
            'bgColor' => '2E74B5',
            'valign' => 'center',
            'borderSize' => 4,
            'borderColor' => 'FFFFFF'
        ];

        $valueStyle = [
            'valign' => 'center',
            'borderSize' => 4,
            'borderColor' => 'D3D3D3'
        ];

        foreach ($data as $recordIndex => $record) {
            // Add separator between records (except before first record)
            if ($recordIndex > 0) {
                $section->addTextBreak(1);
            }

            // Create table for this record
            $table = $section->addTable('RecordTable_'.$recordIndex);
            $phpWord->addTableStyle('RecordTable_'.$recordIndex, $tableStyle);

            // Add each field (skip ID column)
            foreach ($headers as $index => $header) {
                // Skip ID column if header is 'ID'
                if ($header === 'ID' || $header === 'Id') {
                    continue;
                }

                // Get the value using reportColumns mapping
                $value = $record[$this->reportColumns[$index]] ?? '';

                // Format the value
                if (is_array($value)) {
                    $value = implode(', ', $value);
                }
                $value = $value ?? '';

                $table->addRow(400); // Set row height to 0.4 inches

                // Header cell with improved styling
                $table->addCell(3000, $headerStyle)->addText(
                    $header,
                    [
                        'name' => 'Calibri',
                        'size' => 11,
                        'bold' => true,
                        'color' => 'FFFFFF'
                    ],
                    ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]
                );

                // Value cell with improved styling
                $table->addCell(5000, $valueStyle)->addText(
                    $value,
                    [
                        'name' => 'Calibri',
                        'size' => 11
                    ],
                    ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]
                );
            }

            // Add space after each defect record
            $section->addTextBreak(1);
        }

        // Footer with page number
        $footer = $section->addFooter();
        $footer->addPreserveText(
            'Page {PAGE} of {NUMPAGES}',
            [
                'name' => 'Calibri',
                'size' => 9,
                'color' => '7F7F7F'
            ],
            [
                'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
            ]
        );

        // Generate filename with timestamp
        $filename = 'Defect_Report_'.date('Y-m-d_H-i').'.docx';
        $tempPath = storage_path("app/{$filename}");

        try {
            $phpWord->save($tempPath, 'Word2007');
        } catch (\Exception $e) {
            throw new \Exception("Failed to generate document: ".$e->getMessage());
        }

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }

    public function render()
    {
        return view('livewire.reports.defect-report');
    }
}
