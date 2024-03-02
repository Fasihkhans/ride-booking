<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WebSocket Event Listener</title>
</head>
<body>
driver = {{ $bookingId }}
</body>
<style>
    {!! Vite::content('resources/css/app.css') !!}
</style>
<script>
    {!! Vite::content('resources/js/app.js') !!}
</script>
<script>
        console.log(Echo.channel('driver-booking.{{ $bookingId }}'));
        Echo.channel('driver-booking.{{ $bookingId }}')
        .subscribed((channel) => {
        console.log('Subscribed to channel: ' ,channel);
        // Here you can print or do anything else you want when the client subscribes to the channel
        }) .listen('DriverBooking',(e)=>{
            console.log("DriverBooking",e);
        });
</script>
</html>
