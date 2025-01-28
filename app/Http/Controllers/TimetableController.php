<?php

// app/Http/Controllers/TimetableController.php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function show()
    {
        $response = Http::get('https://tahvel.edu.ee/hois_back/timetableevents/timetableByGroup/36', [
            'from' => now()->startOfWeek()->toIsoString(),
            'lang' => 'ET',
            'studentGroups' => 7596,
            'thru' => now()->endOfWeek()->toIsoString(),
        ]);

        $data = collect($response->json()['timetableEvents'])->map(function ($entry) {
            return [
                'name' => data_get($entry, 'nameEt', ''),
                'room' => data_get($entry, 'rooms.0.roomCode', ''),
                'teacher' => data_get($entry, 'teachers.0.name', ''),
                'date' => Carbon::parse(data_get($entry, 'date')),
                'time_start' => data_get($entry, 'timeStart', ''),
                'time_end' => data_get($entry, 'timeEnd', ''),
            ];
        })->sortBy(['date', 'time_start'])
          ->groupBy(function ($event) {
              return $event['date']->translatedFormat('l');
          });

        $startDate = now()->startOfWeek();
        $endDate = now()->endOfWeek();

        return view('timetable.show', compact('data', 'startDate', 'endDate'));
    }
}
    
