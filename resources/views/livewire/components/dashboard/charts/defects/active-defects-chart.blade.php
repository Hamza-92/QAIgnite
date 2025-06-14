<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300">
    <!-- Chart Header -->
    <div class="px-5 py-3 flex items-center justify-between border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
        <div class="flex items-center space-x-3">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                Active Defects (Last 30 Days)
            </h2>
        </div>
    </div>

    {{-- Chart --}}
    <div wire:ignore x-data="activeDefectsChart()" x-init="initChart()" x-cloak class="w-full p-4 relative">
        <div x-ref="chart" class="w-full"></div>
    </div>

    <script>
        function activeDefectsChart() {
            return {
                chart: null,
                isDark: document.documentElement.classList.contains('dark'),
                dates: @json($dates),
                activeDefects: @json($activeDefects),
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
                },

                getChartOptions() {
                    const textColor = this.isDark ? '#E5E7EB' : '#111827';
                    const backgroundColor = this.isDark ? '#1D2938' : '#FFFFFF';
                    const gridColor = this.isDark ? '#374151' : '#E5E7EB';

                    return {
                        theme: {
                            mode: this.isDark ? 'dark' : 'light'
                        },
                        series: [{
                            name: 'Active Defects',
                            data: this.activeDefects,
                            color: '#3B82F6' // Blue
                        }],
                        chart: {
                            type: 'line',
                            height: 380,
                            background: backgroundColor,
                            foreColor: textColor,
                            toolbar: {
                                show: true,
                                tools: {
                                    download: true,
                                    selection: true,
                                    zoom: true,
                                    pan: true,
                                    reset: true
                                },
                                export: {
                                    csv: {
                                        filename: 'active-defects',
                                        headerCategory: 'Date',
                                        headerValue: 'Count',
                                    },
                                    svg: {
                                        filename: 'active-defects',
                                    },
                                    png: {
                                        filename: 'active-defects',
                                    }
                                }
                            },
                            animations: {
                                enabled: true,
                                easing: 'easeinout',
                                speed: 800
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 3
                        },
                        markers: {
                            size: 5,
                            hover: {
                                size: 7
                            }
                        },
                        xaxis: {
                            categories: this.dates,
                            labels: {
                                style: {
                                    colors: textColor
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
                            min: 0,
                            labels: {
                                style: {
                                    colors: textColor
                                }
                            }
                        },
                        grid: {
                            borderColor: gridColor,
                            strokeDashArray: 4
                        },
                        tooltip: {
                            enabled: true,
                            theme: this.isDark ? 'dark' : 'light',
                            y: {
                                formatter: function(value) {
                                    return value + ' active defects';
                                }
                            }
                        }
                    };
                },

                setupDarkModeObserver() {
                    this.observer = new MutationObserver(() => {
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
                    if (this.observer) this.observer.disconnect();
                    if (this.chart) this.chart.destroy();
                }
            };
        }
    </script>
</div>
