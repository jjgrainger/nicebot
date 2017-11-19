<?php

namespace App\Scheduler;

use Carbon\Carbon;

class Kernal
{
    protected $date;

    protected $events = [];

    public function add($event)
    {
        $this->events[] = $event;

        return $event;
    }

    public function getDate()
    {
        if (!$this->date) {
            return Carbon::now();
        }

        return $this->date;
    }

    public function setDate(Carbon $date)
    {
        $this->date = $date;
    }

    public function run()
    {
        foreach ($this->events as $event) {
            if ($event->isDue($this->getDate())) {
                $event->handle();
            }
        }
    }
}
