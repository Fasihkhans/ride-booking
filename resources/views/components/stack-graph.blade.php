<div>
    <canvas id="stackedChart" class="w-full h-auto" ></canvas>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- <script src="{{ asset('js/daterangepicker.js') }}"></script> --}}
        <script>

        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('stackedChart').getContext('2d');

            var stackedChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($labels),
                    datasets: [
                        {
                            label: 'Card',
                            backgroundColor: '#000000',
                            borderRadius	: 10,
                            data: @json($cardDataSet),
                        },
                        {
                            label: 'Cash',
                            backgroundColor: '#FFB800',
                            borderRadius	: 10,
                            data: @json($cashDataSet),
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
        });
        </script>
</div>
