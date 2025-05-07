<!-- resources/views/livewire/components/dashboard/charts/test-case/test-cases-fail-status-chart.blade.php -->

<div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="px-5 py-3 flex items-center justify-between border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Test Case Fail Status</h2>
    </div>

    <div
        wire:ignore
        x-data="testCaseFailurePercentageChart()"
        x-init="initChart()"
        x-cloak
        class="w-full p-4"
    >
        <div x-ref="chart" class="w-full"></div>
    </div>
</div>

<script>
    function testCaseFailurePercentageChart() {
        return {
            chart: null,
            observer: null,
            isDark: document.documentElement.classList.contains('dark'),
            data: @json($weeklyTestCaseFailureData),
            categories: @json($weeklyTestCaseFailureCategories),

            initChart() {
                this.renderChart();

                // Set up MutationObserver to watch for dark mode changes
                this.observer = new MutationObserver((mutations) => {
                    mutations.forEach((mutation) => {
                        if (mutation.attributeName === 'class') {
                            const newDarkState = document.documentElement.classList.contains('dark');
                            if (newDarkState !== this.isDark) {
                                this.isDark = newDarkState;
                                this.renderChart();
                            }
                        }
                    });
                });

                // Start observing the html element for class changes
                this.observer.observe(document.documentElement, {
                    attributes: true,
                    attributeFilter: ['class']
                });
            },

            renderChart() {
                const options = this.getChartOptions();
                if (this.chart) {
                    this.chart.updateOptions(options);
                } else {
                    this.chart = new ApexCharts(this.$refs.chart, options);
                    this.chart.render();
                }
            },

            getChartOptions() {
                const textColor = this.isDark ? '#E5E7EB' : '#111827';
                const gridColor = this.isDark ? '#374151' : '#E5E7EB';
                const backgroundColor = this.isDark ? '#1D2938' : '#FFFFFF';

                return {
                    series: [{
                        name: 'Failure Percentage',
                        data: this.data
                    }],
                    chart: {
                        type: 'line',
                        height: 350,
                        zoom: {
                            enabled: false
                        },
                        toolbar: {
                            show: true,
                            tools: {
                                download: true,
                            }
                        },
                        foreColor: textColor,
                        background: backgroundColor,
                    },
                    colors: [this.isDark ? '#F87171' : '#EF4444'],
                    stroke: {
                        width: 3,
                        curve: 'smooth'
                    },
                    dataLabels: {
                        enabled: false
                    },
                    // markers: {
                    //     size: 5,
                    //     hover: {
                    //         size: 7
                    //     }
                    // },
                    xaxis: {
                        categories: this.categories,
                        labels: {
                            style: {
                                colors: textColor
                            }
                        },
                        axisBorder: {
                            color: gridColor
                        },
                        axisTicks: {
                            color: gridColor
                        }
                    },
                    yaxis: {
                        min: 0,
                        max: 100,
                        opposite: false,
                        labels: {
                            formatter: function(val) {
                                return val + '%';
                            },
                            style: {
                                colors: textColor
                            }
                        }
                    },
                    grid: {
                        borderColor: gridColor,
                        // strokeDashArray: 4
                    },
                    tooltip: {
                        enabled: true,
                        theme: this.isDark ? 'dark' : 'light',
                        y: {
                            formatter: function(value) {
                                return value + '% failed';
                            }
                        }
                    }
                };
            },

            // Clean up observer when component is destroyed
            destroyObserver() {
                if (this.observer) {
                    this.observer.disconnect();
                }
            }
        };
    }
</script>
