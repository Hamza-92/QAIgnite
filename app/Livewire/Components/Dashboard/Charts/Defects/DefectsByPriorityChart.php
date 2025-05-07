<?php

namespace App\Livewire\Components\Dashboard\Charts\Defects;

use Livewire\Component;

class DefectsByPriorityChart extends Component
{
    public $defectsByPriorityCounts = [];
    public function mount() {
        $this->defectsByPriorityCounts = [
            10,
            20,
            15
        ];
    }
    public function render()
    {
        return view('livewire.components.dashboard.charts.defects.defects-by-priority-chart');
    }
}
