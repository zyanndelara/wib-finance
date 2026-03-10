<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Every midnight: save non-remitting riders for the day just ended,
// then reset all rider statuses to 'pending' for the new day.
Schedule::command('remittance:daily-reset')->dailyAt('00:01');
