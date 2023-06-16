<?php

namespace App\Mail\Rdv;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RappelSouscripteur extends Mailable
{
    use Queueable, SerializesModels;

    public $sexe, $name_souscripteur, $name_patient, $motif, $date, $etablissement;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sexe, $name_souscripteur, $name_patient, $motif, $date, $etablissement)
    {
        $this->sexe = $sexe;
        $this->name_souscripteur = $name_souscripteur;
        $this->name_patient = $name_patient;
        $this->motif = $motif;
        $this->date = $date;
        $this->etablissement = $etablissement;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Rendez-vous médical '.$this->name_patient)
            ->from(config('mail.from.address'))
            ->bcc('medsurlink@medicasure.com')
            ->markdown('emails.Rdv.RappelSouscripteur');
    }
}
