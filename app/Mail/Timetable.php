<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;

class Timetable extends Mailable
{
    use Queueable, SerializesModels;

    // Declare public variables for the data passed in the constructor
    public Collection $timetableEvents;
    public Carbon $startDate;
    public Carbon $endDate;

    /**
     * Create a new message instance.
     *
     * @param Collection $timetableEvents
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return void
     */
    public function __construct(Collection $timetableEvents, Carbon $startDate, Carbon $endDate)
    {
        $this->timetableEvents = $timetableEvents;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.timetable')
                    ->with([
                        'timetableEvents' => $this->timetableEvents,
                        'startDate' => $this->startDate,
                        'endDate' => $this->endDate,
                    ]);
    }
}
