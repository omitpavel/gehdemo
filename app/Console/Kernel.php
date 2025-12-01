<?php

namespace App\Console;

use App\Http\Controllers\DataAutoLoad\Camis\CamisDailySummaryController;
use App\Http\Controllers\DataAutoLoad\Symphony\AttendanceSummaryDataAutoController;
use App\Http\Controllers\DataAutoLoad\Symphony\BreachReasonDataAutoController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

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


        $schedule->call(function () {
            Log::info("Automated Daily Camis Summary Insert called at " . now());
            app(CamisDailySummaryController::class)->AutoLoadCamisDailySummary();
        })->everyFiveMinutes();

        $schedule->call(function () {
            Log::info("Automated Daily Camis Summary Insert (Secondary) called at " . now());
            app(CamisDailySummaryController::class)->SecondaryAutoLoadCamisDailySummary();
        })->everyFiveMinutes();



        $schedule->call(function () {
            Log::info("Automated Patient Flag Assign called at " . now());
            app(CamisDailySummaryController::class)->AutoLoadCamisPatientFlagAssign();
        })->everyFiveMinutes();

        $schedule->call(function () {
            Log::info("Automated Daily DP Task Summary Insert called at " . now());
            app(CamisDailySummaryController::class)->TaskSummaryAutoInsert();
        })->everyFiveMinutes();



        $schedule->call(function () {
            Log::info("Automated Breach Reason called at " . now());
            app(BreachReasonDataAutoController::class)->BreachReasonDataAutoInsert();
        })->everyFiveMinutes();

        $schedule->call(function () {
            Log::info("Automated Calculated Daily Attendance Summary called at " . now());
            app(AttendanceSummaryDataAutoController::class)->AttendanceSummaryDataAutoInsert();
        })->everyFiveMinutes();

        $schedule->call(function () {
            Log::info("Automated Calculated Hourly Attendance Summary called at " . now());
            app(AttendanceSummaryDataAutoController::class)->AttendanceSummaryHourlyDataAutoInsert();
        })->everyFiveMinutes();

        $schedule->call(function () {
            Log::info("Camis Hourly Bed Status Data called at " . now());
            app(CamisDailySummaryController::class)->CamisHourlyBedStatusData();
        })->hourlyAt(50);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
