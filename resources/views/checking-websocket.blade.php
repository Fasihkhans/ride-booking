<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WebSocket Event Listener</title>
    <style>
        {!! Vite::content('resources/css/app.css') !!}
    </style>
</head>
<body>
{{ $bookingId }}
<script>
    {!! Vite::content('resources/js/app.js') !!}
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log(Echo.channel('dartscars_database_booking.{{ $bookingId }}')); // this echo is working
        window.Echo.channel('booking.{{ $bookingId }}')
            .listen('.BookingStatus', (event) => {
                console.log(event,'adsf=='); // this not
            });

            window.Echo.channel('booking.{{ $bookingId }}')
                .listen('.App\\Events\\BookingStatus', (event) => {
                    console.log(event, 'Event received');
                });

        });
    // window.Echo.channel('booking.{{$bookingId}}').listen('BookingStatus', (e) => {
    //     console.log("testing", e);
    // });
</script>
</body>
</html>
