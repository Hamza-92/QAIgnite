<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300">
    <!-- Chart Header -->
    <div class="px-5 py-3 flex items-center justify-between border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
        <div class="flex items-center space-x-3">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                Defects Aging Analysis
            </h2>
        </div>
    </div>

    {{-- Chart --}}
    <div wire:ignore x-data="defectsAgingChart()" x-init="initChart()" x-cloak class="w-full p-4 relative">
        <div x-ref="chart" class="w-full"></div>
    </div>

    <script>
        function defectsAgingChart() {
            return {
                chart: null,
                isDark: document.documentElement.classList.contains('dark'),
                ageGroups: @json($ageGroups),
                defectCounts: @json($defectCounts),
                colors: @json($colors),
                observer: null,

                initChart() {
                    this.renderChart();
                    this.setupDarkModeObserver();
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
                            name: 'Open Defects',
                            data: this.defectCounts
                        }],
                        chart: {
                            type: 'bar',
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
                                        filename: 'defects-aging',
                                        headerCategory: 'Age Group',
                                        headerValue: 'Count',
                                    },
                                    svg: {
                                        filename: 'defects-aging',
                                    },
                                    png: {
                                        filename: 'defects-aging',
                                    }
                                }
                            }
                        },
                        colors: this.colors,
                        plotOptions: {
                            bar: {
                                borderRadius: 4,
                                horizontal: false,
                                distributed: true,
                                columnWidth: '60%'
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            style: {
                                fontSize: '12px',
                                fontWeight: 'bold'
                            }
                        },
                        xaxis: {
                            categories: this.ageGroups,
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
                            labels: {
                                style: {
                                    colors: textColor
                                }
                            },
                            axisBorder: {
                                show: true,
                                color: gridColor
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
                                    return value + ' open defects';
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
