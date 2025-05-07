import '../../vendor/masmerise/livewire-toaster/resources/js';

import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.css';
import Chart from 'chart.js/auto';
import ApexCharts from 'apexcharts'

window.flatpickr = flatpickr;
window.Chart = Chart;
window.ApexCharts = ApexCharts;

const userPrefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
const localStorageTheme = localStorage.getItem('color-theme') || localStorage.getItem('darkMode') || localStorage.getItem('flux.appearance') || localStorage.getItem('theme');

if (userPrefersDark || localStorageTheme === 'dark' || localStorageTheme === 'true') {
    import('flatpickr/dist/themes/dark.css');
} else {
    import('flatpickr/dist/themes/light.css');
}
