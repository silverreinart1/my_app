<!-- resources/views/timetable/show.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timetable</title>
</head>
<body>
    <h1>Timetable for the Week</h1>
    
    <p>Start Date: {{ $startDate->format('l, d M Y') }}</p>
    <p>End Date: {{ $endDate->format('l, d M Y') }}</p>

    @foreach ($data as $day => $events)
        <h2>{{ $day }}</h2>

        @foreach ($events as $event)
            <p><strong>{{ $event['name'] }}</strong></p>
            <p>Teacher: {{ $event['teacher'] }}</p>
            <p>Room: {{ $event['room'] }}</p>
            <p>Time: {{ $event['time_start'] }} - {{ $event['time_end'] }}</p>
            <br>
        @endforeach
    @endforeach

</body>
</html>
