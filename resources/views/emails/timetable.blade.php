<!-- resources/views/emails/timetable.blade.php -->

<x-mail::message>
# Timetable for the Week

Start Date: {{ $startDate->format('l, d M Y') }}  
End Date: {{ $endDate->format('l, d M Y') }}

@foreach ($timetableEvents as $date => $events)
    ## {{ $date }}

    @foreach ($events as $event)
        **{{ $event['name'] }}**<br>
        Teacher: {{ $event['teacher'] }}<br>
        Room: {{ $event['room'] }}<br>
        Time: {{ $event['time_start'] }} - {{ $event['time_end'] }}<br><br>
    @endforeach
@endforeach

Thanks,  
{{ config('app.name') }}
</x-mail::message>
