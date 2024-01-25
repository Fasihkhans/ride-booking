<div>
    <div>
        {{-- {{ $startDate }} --}}
        <div  id="reportrange" class="justify-center p-2 border rounded-sm cursor-pointer min-w-min max-w-max justify-self-end"  >
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <i class="fa fa-caret-down"></i>
        </div>

        <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        {{-- @script --}}
        <script>
            $(document).ready(function () {
                $(function() {

                    function cb(start, end) {

                        var start = moment(start ).isValid() ? moment(start) : moment().subtract(29, 'days');
                        var end = moment(end).isValid() ? moment(end) : moment();
                        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                        // setLocalStorage(start, end); // Store the selected date range
                    }
                    cb(@json($startDate), @json($endDate));
                    $('#reportrange').daterangepicker({
                        startDate: {{ $startDate}},
                        endDate: {{ $endDate}},
                        ranges: {
                            'Today': [moment(), moment()],
                            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                            'This Month': [moment().startOf('month'), moment().endOf('month')],
                            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        }
                    }, cb);

                    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
                        const startDate = picker.startDate.format('YYYY-MM-DD');
                        const endDate = picker.endDate.format('YYYY-MM-DD');
                        // window.location.href = `/dashboard?start_date=${startDate}&end_date=${endDate}`;
                        wire = @json($wire);
                        wire.dispatch('date-changed',{startDate: picker.startDate, endDate: picker.endDate})
                        // Livewire.emit('date-changed', {startDate: picker.startDate, endDate: picker.endDate});
                        cb(picker.startDate, picker.endDate);
                    });
                });
            });
        </script>
        {{-- @endscript --}}
    </div>

</div>
