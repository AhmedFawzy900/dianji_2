<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        '\App\Console\Commands\CheckSubscription',
        '\App\Console\Commands\CheckPostJobRequest',
        '\App\Console\Commands\CustomRouteList'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        if(default_earning_type() === 'subscription'){
            $schedule->command('check:subscription')->daily();
        }

        $schedule->command('check:postjobrequest')->daily();

        // check if the order not approved after 24 hour 
        $schedule->call(function () {
            $orders = \App\Models\Booking::where('status', 'pending')
                ->where('created_at', '<', now()->subHours(24))
                ->get();
    
            foreach ($orders as $order) {
                // Send notification or alert
                \App\Notifications\OrderNotApproved::dispatch($order);
            }
        })->daily();

        // check that order exeed time and not start 
        $schedule->call(function () {
            $orders = \App\Models\Booking::where('status', 'accepted')
                ->where('scheduled_time', '<', now())
                ->where('started_at', null)
                ->get();
    
            foreach ($orders as $order) {
                // Send notification or alert
                \App\Notifications\OrderExceededTime::dispatch($order);
            }
        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
