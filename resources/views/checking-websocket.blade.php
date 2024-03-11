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
    console.log(Echo.channel('booking.{{ $bookingId }}'));
    window.Echo.channel('booking.{{$bookingId}}').listen('BookingStatus', (e) => {
        console.log("testing", e);
    });
</script>
</body>
</html>
