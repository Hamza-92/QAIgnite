<div class="">
    <div class="px-8 py-4 flex items-center flex-wrap gap-4 justify-between border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg">Project Dashboard</h2>
    </div>

    {{-- Info Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-8">
        @livewire('components.dashboard.info-card.test-scenario-card')
        @livewire('components.dashboard.info-card.test-case-card')
        @livewire('components.dashboard.info-card.defect-card')
    </div>

    {{-- Charts --}}
    <div x-data="{ activeTab: 'testCases' }" class="w-full px-8 py-4">
        <!-- Tab Headers -->
        <div class="flex gap-1 border-b dark:border-gray-700">
            <button @click="activeTab = 'testCases'" type="button"
                :class="{ 'border-b border-blue-500': activeTab === 'testCases'}"
                class="px-4 py-2 font-medium rounded-t-lg transition-colors duration-300 cursor-pointer">
                Test Cases
            </button>
            <button @click="activeTab = 'defects'" type="button"
                :class="{ 'border-b border-blue-500': activeTab === 'defects' }"
                class="px-4 py-2 font-medium rounded-t-lg transition-colors duration-300 cursor-pointer">
                Defects
            </button>
        </div>
        <!-- Tab Content -->
        {{-- Test Case Tab --}}
        <div x-show="activeTab === 'testCases'" class="py-4 w-full overflow-auto">
            <div class="grid md:grid-cols-2 gap-4">
                @livewire('components.dashboard.charts.test-case.test-case-status-chart')
                @livewire('components.dashboard.charts.test-case.test-case-execution-status-chart')
                @livewire('components.dashboard.charts.test-case.test-cases-fail-status-chart')
            </div>
        </div>
        <div x-show="activeTab === 'defects'" class="py-4 w-full overflow-auto">
            <div class="grid md:grid-cols-2 gap-4">
                @livewire('components.dashboard.charts.defects.defects-by-status-chart')
                @livewire('components.dashboard.charts.defects.defects-by-severity-chart')
                @livewire('components.dashboard.charts.defects.defects-closure-efficiency-chart')
                @livewire('components.dashboard.charts.defects.active-defects-chart')
                @livewire('components.dashboard.charts.defects.defects-aging-chart')
            </div>
        </div>
    </div>
</div>
