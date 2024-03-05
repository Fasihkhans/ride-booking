

@props(['labels', 'cardDataSet', 'cashDataSet'])

<div>
    <canvas id="stackedChart" class="w-full h-auto"></canvas>

    <script>
        // Function to initialize the chart
        function initializeChart(labels, cardDataSet, cashDataSet) {
            var ctx = document.getElementById('stackedChart').getContext('2d');

            var stackedChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Card',
                            backgroundColor: '#000000',
                            borderRadius: 10,
                            data: cardDataSet,
                        },
                        {
                            label: 'Cash',
                            backgroundColor: '#FFB800',
                            borderRadius: 10,
                            data: cashDataSet,
                        },
                    ],
                },
                options: {
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true,
                        },
                    },
                },
            });
        }

        // Load Chart.js asynchronously
        function loadChartJS(callback) {
            var script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
            script.onload = callback;
            document.head.appendChild(script);
        }

        // Load Chart.js and initialize the chart
        loadChartJS(function () {
            initializeChart(@json($labels), @json($cardDataSet), @json($cashDataSet));
        });
    </script>
</div>
