<?php

namespace App\Scheduler;

trait Frequencies
{
    public function cron($expression)
    {
        $this->expression = $expression;

        return $this;
    }

    public function everyMinute()
    {
        return $this->cron($this->expression);
    }

    public function everyTenMinutes()
    {
        return $this->replaceIntoExpression(1, '*/10');
    }

    public function everyThirtyMinutes()
    {
        return $this->replaceIntoExpression(1, '*/30');
    }

    public function hourlyAt($minute = 1)
    {
        return $this->replaceIntoExpression(1, $minute);
    }

    public function hourly()
    {
        return $this->hourlyAt(1);
    }

    public function dailyAt($hour = 0, $minute = 0)
    {
        return $this->replaceIntoExpression(1, [$minute, $hour]);
    }

    public function daily()
    {
        return $this->dailyAt(0, 0);
    }

    public function twiceDaily($firstHour = 1, $lastHour = 12)
    {
        return $this->replaceIntoExpression(1, [0, "{$firstHour},{$lastHour}"]);
    }

    public function days()
    {
        return $this->replaceIntoExpression(5, implode(',', func_get_args() ?: ['*']));
    }

    public function mondays()
    {
        return $this->days(1);
    }

    public function tuesdays()
    {
        return $this->days(2);
    }

    public function wednesdays()
    {
        return $this->days(3);
    }

    public function thursdays()
    {
        return $this->days(4);
    }

    public function fridays()
    {
        return $this->days(5);
    }

    public function saturdays()
    {
        return $this->days(6);
    }

    public function sundays()
    {
        return $this->days(7);
    }

    public function weekdays()
    {
        return $this->days(1, 2, 3, 4, 5);
    }

    public function weekends()
    {
        return $this->days(6, 7);
    }

    public function at($hour = 0, $minute = 0)
    {
        return $this->dailyAt($hour, $minute);
    }

    public function monthly()
    {
        return $this->monthlyOn(1);
    }

    public function monthlyOn($day = 1)
    {
        return $this->replaceIntoExpression(1, [0, 0, $day]);
    }

    public function replaceIntoExpression($position, $value)
    {
        $value = (array) $value;

        $expression = explode(' ', $this->expression);

        array_splice($expression, $position - 1, 1, $value);

        $expression = array_slice($expression, 0, 5);

        return $this->cron(implode(' ', $expression));
    }
}
