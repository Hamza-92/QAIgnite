<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300">
    <!-- Chart Header with Info Badge -->
    <div class="px-5 py-3 flex items-center justify-between border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
        <div class="flex items-center space-x-3">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                Defects by Priority
            </h2>
            <span class="px-2 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-200">
                Last 30 Days
            </span>
        </div>
        <div class="flex items-center space-x-2">
            <button @click="$wire.refreshData()" class="p-1.5 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
            </button>
        </div>
    </div>

    {{-- Chart --}}
    <div wire:ignore x-data="defectsByPriorityChart()" x-init="initChart()" x-cloak class="w-full p-4 relative">
        <div x-ref="chart" class="w-full"></div>
    </div>

    <!-- Chart Footer -->
    <div class="px-5 py-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/30 text-xs text-gray-500 dark:text-gray-400 flex justify-between items-center">
        <div>Updated: {{ now()->format('M j, Y g:i A') }}</div>
        <div class="flex items-center space-x-2">
            <span class="flex items-center">
                <span class="w-2 h-2 rounded-full bg-green-500 mr-1"></span> Low
            </span>
            <span class="flex items-center">
                <span class="w-2 h-2 rounded-full bg-amber-500 mr-1"></span> Medium
            </span>
            <span class="flex items-center">
                <span class="w-2 h-2 rounded-full bg-red-500 mr-1"></span> High
            </span>
        </div>
    </div>

    <script>
        function defectsByPriorityChart() {
            return {
                chart: null,
                isDark: document.documentElement.classList.contains('dark'),
                data: @json($defectsByPriorityCounts),
                labels: ['Low', 'Medium', 'High'],
                observer: null,
                loading: true,

                initChart() {
                    this.renderChart();
                    this.setupDarkModeObserver();
                    setTimeout(() => this.loading = false, 1000); // Simulate loading
                },

                renderChart() {
                    if (this.chart) {
                        this.chart.destroy();
                    }

                    this.chart = new ApexCharts(this.$refs.chart, this.getChartOptions());
                    this.chart.render();
                },

                getChartOptions() {
                    const textColor = this.isDark ? '#E5E7EB' : '#111827';
                    const backgroundColor = this.isDark ? '#1D2938' : '#FFFFFF';
                    const colors = ['#10B981', '#F59E0B', '#EF4444'];

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
                                        filename: 'defects-by-priority',
                                        headerCategory: 'Priority',
                                        headerValue: 'Count',
                                    },
                                    svg: {
                                        filename: 'defects-by-priority',
                                    },
                                    png: {
                                        filename: 'defects-by-priority',
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
                                    const priorities = ['Low', 'Medium', 'High'];
                                    return `<strong>${value} ${priorities[seriesIndex]} priority defects</strong>`;
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
</div>
