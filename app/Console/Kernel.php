<?php

namespace App\Console;

use Artisan;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /*$schedule->call(function ()
        {
            for ($i = 0; $i <= config('constants.NUMBER_OF_QUEUE_ROWS_TO_RUN'); $i++)
            {
                Artisan::call('queue:work', ['--once' => true]);
            }
            Artisan::call('queue:work', ['--queue' => 'high,log_request']);
        })->everyMinute();

        foreach (\DB::getConnections() as $connection)
        {
            $connection->disconnect();
        }

        $schedule->call(function ()
        {
            Artisan::call('geoip:update');
        })->daily();*/
		
		$schedule->command('geoip:update')->daily();
        for ($i = 0; $i <= config('constants.NUMBER_OF_QUEUE_ROWS_TO_RUN'); $i++)
        {
            $schedule->command('queue:work --once --tries=3 --timeout=30')->everyMinute()->withoutOverlapping();
            $schedule->command('queue:work --once --queue=high,log_request --tries=3 --timeout=30')->everyMinute()->withoutOverlapping();
        }
		
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected
    function commands()
    {
        require base_path('routes/console.php');
    }
}
