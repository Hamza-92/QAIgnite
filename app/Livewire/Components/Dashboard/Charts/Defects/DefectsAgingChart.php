<?php

namespace App\Livewire\Components\Dashboard\Charts\Defects;

use App\Models\Defect;
use Carbon\Carbon;
use Livewire\Component;

class DefectsAgingChart extends Component
{
    public $ageGroups = [];
    public $defectCounts = [];
    public $colors = [];

    public function mount()
    {
        $this->prepareChartData();
    }

    public function prepareChartData()
    {
        // Define age groups in days with their labels
        $ageRanges = [
            ['label' => '0-2 days', 'min' => 0, 'max' => 2],
            ['label' => '3-7 days', 'min' => 3, 'max' => 7],
            ['label' => '8-14 days', 'min' => 8, 'max' => 14],
            ['label' => '15-30 days', 'min' => 15, 'max' => 30],
            ['label' => '30+ days', 'min' => 31, 'max' => null]
        ];

        // Get only currently open defects (including reopened)
        $openDefects = Defect::where('def_project_id', auth()->user()->default_project)
            ->where(function ($query) {
                $query->where('def_status', 'open')
                    ->orWhere('def_status', 're-open');
            })
            ->get();

        // Initialize counts for each age group
        foreach ($ageRanges as $range) {
            $this->ageGroups[] = $range['label'];
            $this->defectCounts[] = 0;
        }

        // Count defects in each age group
        foreach ($openDefects as $defect) {
            $ageInDays = Carbon::parse($defect->created_at)->diffInDays(Carbon::now());

            foreach ($ageRanges as $index => $range) {
                if ($range['max'] === null) {
                    if ($ageInDays >= $range['min']) {
                        $this->defectCounts[$index]++;
                        break;
                    }
                } elseif ($ageInDays >= $range['min'] && $ageInDays <= $range['max']) {
                    $this->defectCounts[$index]++;
                    break;
                }
            }
        }

        // Set colors based on severity (red for older defects)
        $this->colors = [
            '#10B981', // 0-2 days (green)
            '#3B82F6', // 3-7 days (blue)
            '#F59E0B', // 8-14 days (yellow)
            '#F97316', // 15-30 days (orange)
            '#EF4444'  // 30+ days (red)
        ];
    }

    public function render()
    {
        return view('livewire.components.dashboard.charts.defects.defects-aging-chart');
    }
}
