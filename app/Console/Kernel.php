<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call('App\Http\Controllers\CronController@getAPIToken')->daily();
        $schedule->call('App\Http\Controllers\CronController@getApplications')->daily();
        $schedule->call('App\Http\Controllers\CronController@getUnitOfMeasurements')->daily();
        $schedule->call('App\Http\Controllers\CronController@getCategories')->daily();
        $schedule->call('App\Http\Controllers\CronController@getSubCategories')->daily();
        $schedule->call('App\Http\Controllers\CronController@getItems')->daily();
        $schedule->call('App\Http\Controllers\CronController@apiSyncPrimaryLabels')->everyTwoHours($minutes = 0);
        $schedule->call('App\Http\Controllers\CronController@apiSyncSecondaryLabels')->everyTwoHours($minutes = 0);
        $schedule->call('App\Http\Controllers\CronController@apiSyncProducts')->everyTwoHours($minutes = 0);
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
