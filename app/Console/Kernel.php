<?php

namespace App\Console;

use Carbon\Carbon;
use App\Jobs\RappelRendezVous;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\rappelerRendezVous;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        rappelerRendezVous::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->command('sms:rappelez-rdv');
//                 ->dailyAt('03:55');
//        $schedule->job(RappelRendezVous::class)->dailyAt('03:55');

        // Vérifier l'activité des utilisateurs toutes les 5 minutes
        $schedule->call(function () {
            // Récupérer les utilisateurs actifs dans les 30 dernières minutes
            $activeUsers = DB::table('time_activities')
                ->select('user_id')
                ->where('stop', '>=', now()->subMinutes(30))
                ->distinct()
                ->get()
                ->pluck('user_id');

            // Mettre à jour les utilisateurs inactifs
            DB::table('time_activities')
                ->whereIn('user_id', $activeUsers)
                ->where('stop', '<', now()->subMinutes(30))
                ->update([
                    'stop' => now(),
                    'temps_connecte' => DB::raw('UNIX_TIMESTAMP(stop) - UNIX_TIMESTAMP(start)'),
                ]);
        })->everyFiveMinutes();

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
