<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Simulasi Data (Dummy dulu, akan diganti data dari Controller)
        const dataWeekly = {
            categories: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            series: [0, 0, 0, 0, 0, 0, 0] 
        };

        const dataMonthly = {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            series: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0] 
        };

        // Konfigurasi Awal Chart
        var options = {
            series: [{
                name: 'Pendapatan',
                data: dataWeekly.series 
            }],
            chart: {
                id: 'sales-chart',
                type: 'area',
                height: 300,
                toolbar: { show: false },
                fontFamily: 'Plus Jakarta Sans, sans-serif',
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                }
            },
            colors: ['#EF4444'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.2,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            xaxis: {
                categories: dataWeekly.categories,
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: { style: { colors: '#94a3b8', fontSize: '11px' } }
            },
            yaxis: {
                labels: {
                    style: { colors: '#94a3b8', fontSize: '11px' },
                    formatter: function (value) {
                        return "Rp " + value;
                    }
                },
                min: 0,
                max: 1000000
            },
            grid: {
                borderColor: '#f1f5f9',
                strokeDashArray: 4,
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "Rp " + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    }
                }
            }
        };

        // Render Chart
        var chart = new ApexCharts(document.querySelector("#salesChart"), options);
        chart.render();

        // Event Listener untuk Dropdown
        const filterSelect = document.getElementById('filterPeriod');
        
        filterSelect.addEventListener('change', function(e) {
            const selectedValue = e.target.value;

            if (selectedValue === 'monthly') {
                chart.updateOptions({
                    xaxis: { categories: dataMonthly.categories }
                });
                chart.updateSeries([{
                    name: 'Pendapatan',
                    data: dataMonthly.series
                }]);
            } else {
                chart.updateOptions({
                    xaxis: { categories: dataWeekly.categories }
                });
                chart.updateSeries([{
                    name: 'Pendapatan',
                    data: dataWeekly.series
                }]);
            }
        });
    });
</script>