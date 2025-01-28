<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Mail\Timetable;

class TimetableNotification extends Command
{
    protected $signature = 'app:timetable-notification';
    protected $description = 'Send timetable notifications for the current week';

    public function handle()
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

        collect(['silverreinart01@gmail.com'])
            ->each(function ($user) use ($data, $startDate, $endDate) {
                Mail::to($user)->send(new Timetable($data, $startDate, $endDate));
            });

        $this->info('Timetable notifications sent!');
    }
}
