<?php

namespace App\Console\Commands;

use App\Models\NonRemittingLog;
use App\Models\Rider;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DailyRemittanceReset extends Command
{
    protected $signature = 'remittance:daily-reset
                            {--date= : Override the date to log as non-remitting (default: yesterday)}';

    protected $description = 'Logs riders who did not remit the previous day, then resets all rider statuses to pending for the new day.';

    public function handle(): int
    {
        $logDate = $this->option('date')
            ? Carbon::parse($this->option('date'))->toDateString()
            : Carbon::yesterday()->toDateString();

        $this->info("Running daily remittance reset for log date: {$logDate}");

        // 1. Find riders who existed on $logDate and did NOT submit any remittance that day
        $nonRemittingRiders = Rider::whereDate('date_created', '<=', $logDate)
            ->where('status', 'active')
            ->whereDoesntHave('remittances', function ($q) use ($logDate) {
                $q->whereDate('created_at', $logDate);
            })->get();

        $loggedCount = 0;
        foreach ($nonRemittingRiders as $rider) {
            NonRemittingLog::updateOrInsert(
                ['rider_id' => $rider->id, 'log_date' => $logDate],
                ['rider_name' => $rider->name, 'updated_at' => now(), 'created_at' => now()]
            );
            $loggedCount++;
        }

        $this->info("Logged {$loggedCount} non-remitting rider(s) for {$logDate}.");

        // 2. Reset ALL riders back to 'pending' for the new day, regardless of whether
        //    they submitted a remittance or not.
        $resetCount = Rider::where('status', 'cleared')
            ->update(['status' => 'pending']);

        $this->info("Reset {$resetCount} rider(s) back to 'pending' status.");

        return Command::SUCCESS;
    }
}
