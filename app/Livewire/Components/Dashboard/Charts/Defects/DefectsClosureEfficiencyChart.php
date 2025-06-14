<?php

namespace App\Livewire\Components\Dashboard\Charts\Defects;

use App\Models\Defect;
use Carbon\Carbon;
use Livewire\Component;

class DefectsClosureEfficiencyChart extends Component
{
    public $dates = [];
    public $totalDefects = [];
    public $closedDefects = [];

    public function mount()
    {
        $this->prepareChartData();
    }

    public function prepareChartData()
{
    $endDate = Carbon::now();
    $startDate = Carbon::now()->subDays(30);

    // Generate 2-day intervals for the last 30 days (15 points)
    $currentDate = $startDate->copy();
    $dateIntervals = [];

    while ($currentDate <= $endDate) {
        $nextDate = $currentDate->copy()->addDays(2);
        if ($nextDate > $endDate) {
            $nextDate = $endDate;
        }

        $dateIntervals[] = [
            'start' => $startDate->copy(),
            'end' => $nextDate,
            'label' => $currentDate->format('M d') . ' - ' . $nextDate->format('M d')
        ];

        $currentDate = $nextDate->copy()->addDay();
    }

    // Get all defects created before end date
    $allDefects = Defect::where('def_project_id', auth()->user()->default_project)
        ->where('created_at', '<=', $endDate)
        ->get();

    // Get all closed defects before end date
    $closedDefects = Defect::where('def_project_id', auth()->user()->default_project)
        ->where('def_status', 'closed')
        ->where('updated_at', '<=', $endDate)
        ->get();

    // Calculate counts for each interval
    foreach ($dateIntervals as $interval) {
        $this->dates[] = $interval['label'];

        // Total defects created up to this interval's end date
        $total = $allDefects->filter(function ($defect) use ($interval) {
            return $defect->created_at <= $interval['end'];
        })->count();

        // Total defects closed up to this interval's end date
        $closed = $closedDefects->filter(function ($defect) use ($interval) {
            return $defect->updated_at <= $interval['end'];
        })->count();

        $this->totalDefects[] = $total;
        $this->closedDefects[] = $closed;
    }
}


    public function render()
    {
        return view('livewire.components.dashboard.charts.defects.defects-closure-efficiency-chart');
    }
}
