<?php

namespace App\Jobs;

use App\Models\RendezVous;
use App\Traits\SmsTrait;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RappelRendezVous implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use SmsTrait;

    protected $personnesARappeler;
    protected $dateRendezVous;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->dateRendezVous = Carbon::tomorrow()->toDateString();
        $rdvs = RendezVous::with('patient')
                ->whereDate('date',$this->dateRendezVous)->get();

        $this->personnesARappeler = $rdvs->pluck('patient');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->personnesARappeler as $user){
            if (!is_null($user)){
                $this->RappelerRdvViaSMSTo($user,$this->dateRendezVous);
            }
        }
    }
}
