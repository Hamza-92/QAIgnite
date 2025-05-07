<div x-data="{ showDataTable: false, showModel: false }"
    class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
    <!-- Chart Header -->
    <div class="px-5 py-3 flex items-center justify-between border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Test Case Execution Summary</h2>
        <button @click="showModel = true" title="Filter"
            class="flex items-center gap-1 px-3 py-1.5 text-sm rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
        </button>
    </div>

    <div wire:ignore x-data="testCycleResultsChart()" x-init="initChart()" @chart-updated.window="updateChart($event.detail)"
        x-cloak class="w-full p-2">
        <div x-ref="chart" class="w-full"></div>
    </div>

    <script>
        function testCycleResultsChart() {
            return {
                chart: null,
                isDark: document.documentElement.classList.contains('dark'),
                passedCounts: @json($passedCounts),
                failedCounts: @json($failedCounts),
                notExecutedCounts: @json($notExecutedCounts),
                cycleNames: @json($cycleNames),
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

                    this.passedCounts = data?.passedCounts || [];
                    this.failedCounts = data?.failedCounts || [];
                    this.notExecutedCounts = data?.notExecutedCounts || [];
                    this.cycleNames = data?.cycleNames || [];

                    this.chart.updateOptions({
                        series: this.getSeriesData(),
                        xaxis: {
                            categories: this.cycleNames
                        }
                    });
                },

                getSeriesData() {
                    return [{
                        name: 'Passed',
                        data: this.passedCounts,
                        color: this.isDark ? '#10B981' : '#059669'
                    }, {
                        name: 'Failed',
                        data: this.failedCounts,
                        color: this.isDark ? '#EF4444' : '#DC2626'
                    }, {
                        name: 'Not Executed',
                        data: this.notExecutedCounts,
                        color: this.isDark ? '#6B7280' : '#9CA3AF'
                    }];
                },

                getChartOptions() {
                    const textColor = this.isDark ? '#E5E7EB' : '#111827';
                    const gridColor = this.isDark ? '#374151' : '#E5E7EB';
                    const backgroundColor = this.isDark ? '#1D2938' : '#FFFFFF';

                    return {
                        series: this.getSeriesData(),
                        chart: {
                            type: 'bar',
                            height: 380,
                            stacked: true,
                            background: backgroundColor,

                            animations: {
                                enabled: true,
                                easing: 'easeinout',
                                speed: 800
                            },
                            events: {
                                click: (event, chartContext, config) => {
                                    if (config.seriesIndex !== undefined && config.dataPointIndex !== undefined) {
                                        const cycleName = this.cycleNames[config.dataPointIndex];
                                        if (cycleName) {
                                            Livewire.dispatch('showTestCycleDetails', {
                                                cycleName: cycleName
                                            });
                                            this.showDataTable = true;
                                        }
                                    }
                                }
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                borderRadius: 4,
                                columnWidth: '80%',
                                borderRadiusApplication: 'end',
                                borderRadiusWhenStacked: 'last'
                            }
                        },
                        xaxis: {
                            categories: this.cycleNames,
                            labels: {
                                style: {
                                    colors: textColor,
                                    fontSize: '12px'
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
                                }
                            },
                            axisBorder: {
                                show: true,
                                color: gridColor
                            }
                        },
                        grid: {
                            borderColor: gridColor,
                        },
                        legend: {
                            position: 'top',
                            horizontalAlign: 'center',
                            labels: {
                                colors: textColor
                            }
                        },
                        tooltip: {
                            enabled: true,
                            shared: true,
                            intersect: false,
                            theme: this.isDark ? 'dark' : 'light'
                        },
                        responsive: [{
                            breakpoint: 768,
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
                        this.isDark = document.documentElement.classList.contains('dark');
                        this.chart.updateOptions({
                            theme: {
                                mode: this.isDark ? 'dark' : 'light'
                            },
                            chart: {
                                background: this.isDark ? '#1D2938' : '#FFFFFF',
                                foreground: this.isDark ? '#E5E7EB' : '#111827'
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
                            },
                            legend: {
                                labels: {
                                    colors: this.isDark ? '#E5E7EB' : '#111827'
                                }
                            },
                            // series: this.getSeriesData()
                        });
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


    {{-- Filter --}}

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
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Test Case Execution Filter</h4>
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
                {{-- Cycle ID --}}
                <x-single-select-box label='Cycle ID' model='cycle_id' live='true'>
                    <option value="all">All</option>
                    @forelse ($filterCycles as $cycle)
                        <option class="overflow-ellipsis" wire:key='{{ $cycle->id }}' value="{{ $cycle->id }}">
                            {{ $cycle->name }}</option>
                    @empty
                    @endforelse
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
    <div x-show='showDataTable' x-cloak @keydown.escape.window="showDataTable = false"
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
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $tableData->name ?? '' }}</h4>
                </div>
                <button @click="showDataTable = false; $wire.tableData = []" type="button"
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
                                Test Case ID
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
                        @isset($tableData)

                            @forelse ($tableData->testCases as $testCase)
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
                                            'text-green-500' => $testCase->pivot->status === 'Passed',
                                            'text-gray-500' => $testCase->pivot->status === 'Not Executed',
                                            'text-red-500' => $testCase->pivot->status === 'Failed',
                                        ])>
                                            {{ $testCase->pivot->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3"
                                        class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                        <span wire:loading>Loading...</span>
                                        <span wire:loading.remove>No data found</span>
                                    </td>
                                </tr>
                            @endforelse
                        @endisset
                    </tbody>
                </table>
            </div>
            {{-- Modal Footer --}}
            <div
                class="flex items-center justify-end gap-4 px-5 py-3 border-t dark:border-gray-700 bg-white dark:bg-gray-800">
                <button @click="showDataTable = false; $wire.tableData = []" type="button"
                    class="px-4 py-2 text-sm font-medium bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    Close
                </button>
                @isset($tableData)
                    <a class="px-4 py-2 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 flex items-center gap-2"
                        href="{{ route('test-case-execution.list', $tableData->id) }}" wire:navigate>
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
