<?php

namespace App\Livewire\Components\Dashboard\Charts\Defects;

use App\Models\Defect;
use Livewire\Attributes\On;
use Livewire\Component;

class DefectsBySeverityChart extends Component
{
    public $defectStatusLabels;
    public $defectStatusCounts;
    public $defectsBySeverity;

    public function mount() {
        $this->defectStatusLabels = [];
        $this->defectStatusCounts = [];
        $this->defectsBySeverity = [];

        $this->prepareChartData();
    }

    public function prepareChartData() {
        $severities = ['blocker', 'major', 'minor'];

        $data = Defect::where('def_project_id', auth()->user()->default_project)
            ->select('def_severity', \DB::raw('count(*) as count'))
            ->whereIn('def_severity', $severities)
            ->groupBy('def_severity')
            ->get()
            ->keyBy('def_severity');

        $this->defectStatusLabels = $severities;
        $this->defectStatusCounts = array_map(function($severity) use ($data) {
            return isset($data[$severity]) ? $data[$severity]->count : 0;
        }, $severities);
    }

    #[On('showDefectsBySeverity')]
    public function showDefectsBySeverity($defectSeverity) {
        $this->defectsBySeverity = Defect::where('def_project_id', auth()->user()->default_project)
            ->where('def_severity', $defectSeverity)
            ->get();

        // $this->dispatch('show-modal'); // Dispatch event to show the modal
    }

    public function render()
    {
        return view('livewire.components.dashboard.charts.defects.defects-by-severity-chart');
    }
}
