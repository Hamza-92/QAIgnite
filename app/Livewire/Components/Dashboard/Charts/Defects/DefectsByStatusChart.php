<?php

namespace App\Livewire\Components\Dashboard\Charts\Defects;

use App\Models\Defect;
use Livewire\Component;

class DefectsByStatusChart extends Component
{
    public $defectStatusLabels;
    public $defectStatusCounts;

    public function mount() {
        $this->defectStatusLabels = [];
        $this->defectStatusCounts = [];

        $this->prepareChartData();
    }

    public function prepareChartData() {
        $data = Defect::where('def_project_id', auth()->user()->default_project)
            ->select('def_status', \DB::raw('count(*) as count'))
            ->groupBy('def_status')
            ->get();

        $this->defectStatusLabels = $data->pluck('def_status')->toArray();
        $this->defectStatusCounts = $data->pluck('count')->toArray();

        dd($this->defectStatusLabels, $this->defectStatusCounts);
    }

    public function render()
    {
        return view('livewire.components.dashboard.charts.defects.defects-by-status-chart');
    }
}
