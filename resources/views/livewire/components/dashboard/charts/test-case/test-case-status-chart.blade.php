<div x-data="{ showModel: false }"
    class="bg-white rounded-lg dark:bg-gray-800 border dark:border-gray-700 transition-colors duration-300">
    {{-- Chart Header --}}
    <div class="px-5 py-3 flex items-center justify-between border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Test Case Status</h2>
        <button @click="showModel = true" title="Filter"
            class="flex items-center gap-1 px-3 py-1.5 text-sm rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
        </button>
    </div>

    <div wire:ignore x-data="testCaseStatusChart()" x-init="initChart()" x-cloak
        @test-case-status-chart-updated.window="updateChart($event.detail)" class="w-full p-2">
        <div x-ref="chart" class="w-full"></div>
    </div>

    <script>
        function testCaseStatusChart() {
            return {
                chart: null,
                isDark: document.documentElement.classList.contains('dark'),
                approved: @json($testCaseStatusCounts['approved']),
                pending: @json($testCaseStatusCounts['pending']),
                rejected: @json($testCaseStatusCounts['rejected']),
                darkModeObserver: null,

                initChart() {
                    this.setupDarkModeListener();
                    this.renderChart();
                },

                renderChart() {
                    if (this.chart) {
                        this.chart.destroy();
                    }
                    this.chart = new ApexCharts(this.$refs.chart, this.getChartOptions());
                    this.chart.render();
                },

                updateChart(newData) {
                    const data = Array.isArray(newData) ? newData[0] : newData;
                    this.approved = data.approved;
                    this.pending = data.pending;
                    this.rejected = data.rejected;

                    this.chart.updateOptions({
                        series: [{
                            name: 'Test Cases',
                            data: [this.approved, this.pending, this.rejected]
                        }]
                    });
                },

                getBarColors() {
                    return [
                        '#10B981', // Approved - Green
                        '#F59E0B', // Pending - Amber
                        '#EF4444' // Rejected - Red
                    ];
                },

                getChartOptions() {
                    const textColor = this.isDark ? '#E5E7EB' : '#111827';
                    const gridColor = this.isDark ? '#374151' : '#E5E7EB';
                    const backgroundColor = this.isDark ? '#1D2938' : '#FFFFFF';

                    return {
                        theme: {
                                mode: this.isDark ? 'dark' : 'light'
                            },
                        series: [{
                            name: 'Test Cases',
                            data: [this.approved, this.pending, this.rejected]
                        }],
                        chart: {
                            type: 'bar',
                            height: 380,
                            background: backgroundColor,
                            foreColor: textColor,
                            toolbar: {
                                show: true,
                                tools: {
                                    download: true
                                },
                            },
                            animations: {
                                enabled: true,
                                easing: 'easeinout',
                                speed: 800
                            },
                            events: {
                                click: (event, chartContext, config) => {
                                    if (config.dataPointIndex !== undefined) {
                                        const statuses = ['approved', 'pending', 'rejected'];
                                        const status = statuses[config.dataPointIndex];
                                        if (status) {
                                            Livewire.dispatch('showTestCaseStatusData', {
                                                status: status
                                            });
                                        }
                                    }
                                }
                            }
                        },
                        colors: this.getBarColors(),
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '80%',
                                borderRadius: 4,
                                distributed: true
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            style: {
                                fontSize: '12px'
                            },
                            formatter: function(val) {
                                return val > 0 ? val : '';
                            }
                        },
                        xaxis: {
                            categories: ['Approved', 'Pending', 'Rejected'],
                            labels: {
                                style: {
                                    colors: textColor,
                                    fontSize: '12px',
                                    fontWeight: 600
                                }
                            },
                            axisBorder: {
                                show: true,
                                color: gridColor
                            },
                            axisTicks: {
                                show: true,
                                color: gridColor
                            }
                        },
                        yaxis: {
                            labels: {
                                style: {
                                    colors: textColor,
                                    fontSize: '12px'
                                },
                                formatter: function(val) {
                                    return Math.floor(val) === val ? val : '';
                                }
                            },
                            axisBorder: {
                                show: true,
                                color: gridColor
                            },
                            forceNiceScale: true,
                        },
                        grid: {
                            borderColor: gridColor,
                            // strokeDashArray: 4
                        },
                        legend: {
                            position: 'top',
                            horizontalAlign: 'center',
                        },
                        tooltip: {
                            enabled: true,
                            theme: this.isDark ? 'dark' : 'light'
                        },
                        responsive: [{
                            breakpoint: 640,
                            options: {
                                chart: {
                                    height: 300
                                },
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }]
                    };
                },

                setupDarkModeListener() {
                    if (this.darkModeObserver) {
                        this.darkModeObserver.disconnect();
                    }

                    this.darkModeObserver = new MutationObserver(() => {
                        const newDarkMode = document.documentElement.classList.contains('dark');
                        if (newDarkMode !== this.isDark) {
                            this.isDark = newDarkMode;
                            if (this.chart) {
                                this.chart.updateOptions({
                                    theme: {
                                        mode: this.isDark ? 'dark' : 'light'
                                    },
                                    chart: {
                                        background: this.isDark ? '#1D2938' : '#FFFFFF',
                                        foreColor: this.isDark ? '#E5E7EB' : '#111827'
                                    },
                                    xaxis: {
                                        labels: {
                                            style: {
                                                colors: this.isDark ? '#E5E7EB' : '#111827'
                                            }
                                        }
                                    },
                                    yaxis: {
                                        labels: {
                                            style: {
                                                colors: this.isDark ? '#E5E7EB' : '#111827'
                                            }
                                        }
                                    },
                                    grid: {
                                        borderColor: this.isDark ? '#374151' : '#E5E7EB'
                                    }
                                });
                            }
                        }
                    });

                    this.darkModeObserver.observe(document.documentElement, {
                        attributes: true,
                        attributeFilter: ['class']
                    });
                },

                destroy() {
                    if (this.darkModeObserver) {
                        this.darkModeObserver.disconnect();
                    }
                    if (this.chart) {
                        this.chart.destroy();
                    }
                }
            };
        }
    </script>

    {{-- Filter Modal --}}
    <div x-show='showModel' x-cloak @keydown.escape.window="showModel = false"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div @click.away="showModel = false"
            class="bg-white dark:bg-gray-800 rounded-lg w-full max-w-md flex flex-col overflow-hidden border border-gray-200 dark:border-gray-700"
            style="max-height: calc(100vh - 2rem);"> <!-- Added max-height calculation -->

            {{-- Modal Header --}}
            <div
                class="flex items-center justify-between px-5 py-3 border-b dark:border-gray-700 bg-white dark:bg-gray-800 sticky top-0 z-10">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Filter Test Cases</h4>
                </div>
                <button @click='showModel = false'
                    class="p-2 rounded-full text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                    title="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="flex-1 overflow-y-auto p-5 space-y-4">
                {{-- Build ID --}}
                <x-single-select-box label='Build' model='build_id' live='true'>
                    <option value="all">All</option>
                    @forelse ($builds as $build)
                        <option class="overflow-ellipsis" wire:key='{{ $build->id }}' value="{{ $build->id }}">
                            {{ $build->name }}</option>
                    @empty
                    @endforelse
                </x-single-select-box>

                {{-- Module --}}
                <x-single-select-box label='Module' model='module_id' live='true'>
                    <option value="all">All</option>
                    @isset($modules)
                        @foreach ($modules as $module)
                            <option class="hover:text-white" wire:key='{{ $module->id }}' value="{{ $module->id }}">
                                {{ $module->module_name }}</option>
                        @endforeach
                    @endisset
                </x-single-select-box>

                {{-- Requirements --}}
                <x-single-select-box label='Requirement' model='requirement_id' live='true'>
                    <option value="all">All</option>
                    @isset($requirements)
                        @foreach ($requirements as $requirement)
                            <option class="hover:text-white" wire:key='{{ $requirement->id }}'
                                value="{{ $requirement->id }}">{{ $requirement->requirement_title }}</option>
                        @endforeach
                    @endisset
                </x-single-select-box>

                {{-- Test Scenario --}}
                <x-single-select-box label='Test Scenario' model='test_scenario_id' live='true'>
                    <option value="all">All</option>
                    @isset($test_scenarios)
                        @foreach ($test_scenarios as $test_scenario)
                            <option class="hover:text-white" wire:key='{{ $test_scenario->id }}'
                                value="{{ $test_scenario->id }}">{{ $test_scenario->ts_name }}</option>
                        @endforeach
                    @endisset
                </x-single-select-box>

                {{-- Priority --}}
                <x-single-select-box label='Priority' model='priority' live='true'>
                    <option value="all">All</option>
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                </x-single-select-box>

                {{-- Testing Type --}}
                <x-single-select-box label='Testing Type' model='testing_type' live='true'>
                    <option value="all">All</option>
                    <option value="field-validation">Field Validation</option>
                    <option value="content">Content</option>
                    <option value="cross-browser/os">Cross Browser/OS</option>
                    <option value="ui/ux">UI/UX</option>
                    <option value="security">Security</option>
                    <option value="performance">Performance</option>
                    <option value="functional">Functional</option>
                </x-single-select-box>
            </div>

            {{-- Modal Footer --}}
            <div class="px-5 py-3 border-t dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 sticky bottom-0">
                <div class="flex justify-end gap-2">
                    <button wire:click='clearFilters'
                        class="px-4 py-2 text-sm rounded-md text-gray-700 dark:text-gray-300 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors">
                        Clear Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Data Modal --}}
    <div x-show='$wire.showDataModel' x-cloak @keydown.escape.window="$wire.hideTestCaseDataModel()"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div
            class="bg-white dark:bg-gray-800 rounded-lg w-full max-w-4xl max-h-[90vh] flex flex-col overflow-hidden border border-gray-200 dark:border-gray-700">
            {{-- Modal Header --}}
            <div
                class="flex items-center justify-between px-5 py-3 border-b dark:border-gray-700 bg-white dark:bg-gray-800 sticky top-0">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Test Case Details</h4>
                </div>
                <button wire:click='hideTestCaseDataModel'
                    class="p-2 rounded-full text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                    title="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="flex-1 overflow-y-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700 sticky top-0 z-10">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Description
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($testCaseData as $testCase)
                            <tr wire:key='{{ $testCase->id }}'
                                class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    <a class="underline hover:text-blue-500"
                                        href="{{ route('test-case.detail', [$testCase->id]) }}" wire:navigate>
                                        {{ $testCase->tc_name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    <div class="max-w-xs truncate">
                                        {{ $testCase->tc_description }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span @class([
                                        'px-2 py-1 text-xs font-semibold rounded-full',
                                        'text-green-500' => $testCase->tc_status === 'approved',
                                        'text-yellow-500' => $testCase->tc_status === 'pending',
                                        'text-red-500' => $testCase->tc_status === 'rejected',
                                    ])>
                                        {{ ucfirst($testCase->tc_status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3"
                                    class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No test cases found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Modal Footer --}}
            <div
                class="flex items-center justify-end gap-4 px-5 py-3 border-t dark:border-gray-700 bg-white dark:bg-gray-800">
                <button wire:click='hideTestCaseDataModel'
                    class="px-4 py-2 text-sm font-medium bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    Close
                </button>
                @isset($testCaseData)
                    <a class="px-4 py-2 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 flex items-center gap-2"
                        href="{{ route('test-cases') }}" wire:navigate>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        View Full Details
                    </a>
                @endisset
            </div>
        </div>
    </div>
</div>
