<?php

namespace App\Scheduler;

use App\Scheduler\Frequencies;
use Carbon\Carbon;
use Cron\CronExpression;

abstract class Job
{
    use Frequencies;

    /**
     * The cron expression for this event.
     *
     * @var string
     */
    public $expression = '* * * * *';

    /**
     * Handle the event.
     *
     * @return void
     */
    abstract public function handle();

    /**
     * Check if the event is due to run.
     *
     * @param  Carbon  $date
     * @return boolean
     */
    public function isDue(Carbon $date)
    {
        return CronExpression::factory($this->expression)->isDue($date);
    }
}
