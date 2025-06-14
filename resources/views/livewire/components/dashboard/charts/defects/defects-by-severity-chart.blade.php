<div x-data="{showDataTable:false}" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300">
    <!-- Chart Header with Info Badge -->
    <div class="px-5 py-3 flex items-center justify-between border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
        <div class="flex items-center space-x-3">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                Defects by Severity
            </h2>
        </div>
    </div>

    {{-- Chart --}}
    <div wire:ignore x-data="defectsBySeverityChart()" x-init="initChart()" x-cloak class="w-full p-4 relative">
        <div x-ref="chart" class="w-full"></div>
    </div>

    <script>
        function defectsBySeverityChart() {
            return {
                chart: null,
                isDark: document.documentElement.classList.contains('dark'),
                data: @json($defectStatusCounts),
                labels: @json($defectStatusLabels),
                observer: null,
                loading: true,

                initChart() {
                    this.renderChart();
                    this.setupDarkModeObserver();
                    setTimeout(() => this.loading = false, 1000);
                },

                renderChart() {
                    if (this.chart) {
                        this.chart.destroy();
                    }

                    this.chart = new ApexCharts(this.$refs.chart, this.getChartOptions());
                    this.chart.render();

                    // Add click event handler
                    this.chart.w.globals.dom.Paper.node.addEventListener('click', (e) => {
                        if (e.target.getAttribute('rel') === 'slice') {
                            const sliceIndex = e.target.getAttribute('realIndex');
                            const defectSeverity = this.labels[sliceIndex];
                            Livewire.dispatch('showDefectsBySeverity', {
                                defectSeverity: defectSeverity
                            });
                            this.showDataTable = true;
                        }
                    });
                },

                getChartOptions() {
                    const textColor = this.isDark ? '#E5E7EB' : '#111827';
                    const backgroundColor = this.isDark ? '#1D2938' : '#FFFFFF';
                    const colors = ['#EF4444', '#F59E0B', '#10B981']; // Red, Yellow, Green for Blocker, Major, Minor

                    return {
                        theme: {
                            mode: this.isDark ? 'dark' : 'light'
                        },
                        series: this.data,
                        chart: {
                            type: 'donut',
                            height: 380,
                            background: backgroundColor,
                            foreColor: textColor,
                            toolbar: {
                                show: true,
                                tools: {
                                    download: true,
                                    selection: false,
                                    zoom: false,
                                    pan: false,
                                    reset: false
                                },
                                export: {
                                    csv: {
                                        filename: 'defects-by-severity',
                                        headerCategory: 'Severity',
                                        headerValue: 'Count',
                                    },
                                    svg: {
                                        filename: 'defects-by-severity',
                                    },
                                    png: {
                                        filename: 'defects-by-severity',
                                    }
                                }
                            },
                            animations: {
                                enabled: true,
                                easing: 'easeinout',
                                speed: 800,
                                animateGradually: {
                                    enabled: true,
                                    delay: 150
                                },
                                dynamicAnimation: {
                                    enabled: true,
                                    speed: 350
                                }
                            },
                            events: {
                                dataPointSelection: (event, chartContext, config) => {
                                    const defectSeverity = this.labels[config.dataPointIndex];
                                    Livewire.dispatch('showDefectsBySeverity', {
                                        defectSeverity: defectSeverity
                                    });
                                    this.showDataTable = true;
                                }
                            }
                        },
                        labels: this.labels,
                        colors: colors,
                        legend: {
                            position: 'bottom',
                            horizontalAlign: 'center',
                            fontSize: '13px',
                            labels: {
                                colors: textColor,
                                useSeriesColors: false
                            },
                            markers: {
                                width: 8,
                                height: 8,
                                radius: 12
                            },
                            itemMargin: {
                                horizontal: 10,
                                vertical: 5
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            style: {
                                fontSize: '13px',
                                fontFamily: 'Inter, sans-serif',
                                fontWeight: 600
                            },
                            dropShadow: {
                                enabled: true,
                                top: 1,
                                left: 1,
                                blur: 1,
                                opacity: 0.3
                            }
                        },
                        tooltip: {
                            enabled: true,
                            fillSeriesColor: false,
                            theme: this.isDark ? 'dark' : 'light',
                            style: {
                                fontSize: '13px',
                                fontFamily: 'Inter, sans-serif'
                            },
                            y: {
                                formatter: function(value, { seriesIndex }) {
                                    const severities = @json($defectStatusLabels);
                                    return `<strong>${value} ${severities[seriesIndex]} defects</strong>`;
                                }
                            }
                        },
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '65%',
                                    labels: {
                                        show: true,
                                        name: {
                                            show: true,
                                            fontSize: '13px',
                                            color: textColor
                                        },
                                        value: {
                                            show: true,
                                            fontSize: '20px',
                                            fontWeight: 700,
                                            color: textColor,
                                            formatter: function(val) {
                                                return val;
                                            }
                                        },
                                        total: {
                                            show: true,
                                            showAlways: true,
                                            label: 'Total Defects',
                                            fontSize: '13px',
                                            fontWeight: 600,
                                            color: textColor,
                                            formatter: function(w) {
                                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                            }
                                        }
                                    }
                                },
                                customScale: 1,
                                offsetY: 0,
                                startAngle: 0,
                                endAngle: 360,
                                expandOnClick: true
                            }
                        },
                        stroke: {
                            width: 1,
                            colors: [backgroundColor]
                        },
                        responsive: [{
                            breakpoint: 640,
                            options: {
                                chart: {
                                    height: 320
                                },
                                legend: {
                                    position: 'bottom',
                                    horizontalAlign: 'center'
                                }
                            }
                        }]
                    };
                },

                setupDarkModeObserver() {
                    if (this.observer) {
                        this.observer.disconnect();
                    }

                    this.observer = new MutationObserver((mutations) => {
                        const newDarkState = document.documentElement.classList.contains('dark');
                        if (newDarkState !== this.isDark) {
                            this.isDark = newDarkState;
                            this.updateChartTheme();
                        }
                    });

                    this.observer.observe(document.documentElement, {
                        attributes: true,
                        attributeFilter: ['class']
                    });
                },

                updateChartTheme() {
                    this.renderChart();
                },

                destroy() {
                    if (this.observer) {
                        this.observer.disconnect();
                    }
                    if (this.chart) {
                        this.chart.destroy();
                    }
                }
            };
        }
    </script>

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
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Defect Details</h4>
                </div>
                <button @click="showDataTable = false; $wire.defectsBySeverity = []" type="button"
                    class="p-2 rounded-full text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                    title="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700 sticky top-0 z-10">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Defect ID
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Description
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Severity
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @isset($defectsBySeverity)
                            @forelse ($defectsBySeverity as $defect)
                                <tr wire:key='{{ $defect->id }}'
                                    class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        <a class="underline hover:text-blue-500" target="_blank"
                                            href="{{ route('defect.detail',[$defect->id]) }}">
                                            {{ $defect->def_name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        <div class="max-w-xs truncate">
                                            {{ $defect->def_description }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span @class([
                                            'px-2 py-1 text-xs font-semibold rounded-full',
                                            'text-green-500' => $defect->def_severity === 'minor',
                                            'text-yellow-500' => $defect->def_severity === 'major',
                                            'text-red-500' => $defect->def_severity === 'blocker',
                                        ])>
                                            {{ $defect->def_severity }}
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
        </div>
    </div>
</div>
