<?php

namespace App\Livewire\Components\Dashboard\Charts\TestCase;

use App\Models\TestCaseExecution;
use Carbon\Carbon;
use Livewire\Component;

class TestCasesFailStatusChart extends Component
{
    public $weeklyTestCaseFailureData = [];
    public $weeklyTestCaseFailureCategories = [];

    public function mount() {
        $this->prepareChartData();
    }

    public function prepareChartData() {
        $endDate = Carbon::yesterday();
        $startDate = $endDate->copy()->subWeeks(6)->startOfWeek();

        $currentWeekStart = $startDate->copy();

        while ($currentWeekStart <= $endDate) {
            $currentWeekEnd = $currentWeekStart->copy()->endOfWeek();
            if ($currentWeekEnd > $endDate) {
                $currentWeekEnd = $endDate;
            }

            $weekLabel = $currentWeekStart->format('d M') . ' - ' . $currentWeekEnd->format('d M');

            $totalCases = TestCaseExecution::whereBetween('created_at', [
                $currentWeekStart, $currentWeekEnd
            ])->count();

            $failedCases = TestCaseExecution::whereBetween('created_at', [
                $currentWeekStart, $currentWeekEnd
            ])->where('status', 'failed')->count();

            $failurePercentage = $totalCases > 0 ? round(($failedCases / $totalCases) * 100, 2) : 0;

            $this->weeklyTestCaseFailureData[] = $failurePercentage;
            $this->weeklyTestCaseFailureCategories[] = $weekLabel;

            $currentWeekStart->addWeek();
        }
        // dd($this->weeklyTestCaseFailureData, $this->weeklyTestCaseFailureCategories);
    }
    public function render()
    {
        return view('livewire.components.dashboard.charts.test-case.test-cases-fail-status-chart');
    }
}
