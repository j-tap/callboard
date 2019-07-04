<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\Client\Api\v1\DealController;

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
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // смотрим , если объявления просрочены, то убираем их
        $schedule->call(function () {
            $queue = new DealController();
            $queue->runDeleteDealsBeforeToDateWorker();
        })->name('runDeleteDealsBeforeToDateWorker')->withoutOverlapping(); // withoutOverlapping - чтобы не было перекрытия выполняемых задач
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
