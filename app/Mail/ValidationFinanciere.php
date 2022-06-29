<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ValidationFinanciere extends Mailable
{
    use Queueable, SerializesModels;

    public $souscripteur, $patient, $examens;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($souscripteur, $patient, $examens)
    {
        $this->souscripteur = $souscripteur;
        $this->patient = $patient;
        $this->examens = $examens;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Validation Financière')
            ->markdown('emails.Souscripteur.validationFinanciere');
    }
}
