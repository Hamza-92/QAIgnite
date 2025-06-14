<div
    class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300">
    <!-- Chart Header -->
    <div
        class="px-5 py-3 flex items-center justify-between border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
        <div class="flex items-center space-x-3">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                Defect Closure Efficiency (Last 30 Days)
            </h2>
        </div>
    </div>

    {{-- Chart --}}
    <div wire:ignore x-data="defectClosureEfficiencyChart()" x-init="initChart()" x-cloak class="w-full p-4 relative">
        <div x-ref="chart" class="w-full"></div>
    </div>

    <script>
        function defectClosureEfficiencyChart() {
            return {
                chart: null,
                isDark: document.documentElement.classList.contains('dark'),
                dates: @json($dates),
                totalDefects: @json($totalDefects),
                closedDefects: @json($closedDefects),
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
                                name: 'Total Defects',
                                data: this.totalDefects,
                                color: '#3B82F6' // Blue
                            },
                            {
                                name: 'Closed Defects',
                                data: this.closedDefects,
                                color: '#10B981' // Green
                            }
                        ],
                        chart: {
                            type: 'area',
                            height: 380,
                            background: backgroundColor,
                            foreColor: textColor,
                            stacked: false,
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
                                        filename: 'defect-closure-efficiency',
                                        headerCategory: 'Date',
                                        headerValue: 'Count',
                                    },
                                    svg: {
                                        filename: 'defect-closure-efficiency',
                                    },
                                    png: {
                                        filename: 'defect-closure-efficiency',
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
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                inverseColors: false,
                                opacityFrom: 0.5,
                                opacityTo: 0.1,
                                stops: [0, 90, 100]
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
                            labels: {
                                style: {
                                    colors: textColor
                                }
                            }
                        },
                        grid: {
                            borderColor: gridColor,
                            strokeDashArray: 4,
                            padding: {
                                top: 0,
                                right: 20,
                                bottom: 0,
                                left: 20
                            }
                        },
                        tooltip: {
                            enabled: true,
                            theme: this.isDark ? 'dark' : 'light',
                            style: {
                                fontSize: '13px',
                                fontFamily: 'Inter, sans-serif'
                            },
                        },
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
