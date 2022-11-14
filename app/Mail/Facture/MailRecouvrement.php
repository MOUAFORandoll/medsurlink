<?php

namespace App\Mail\Facture;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailRecouvrement extends Mailable
{
    use Queueable, SerializesModels;
    public $facture;
    public $souscripteur;
    public $path;
    public $total;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($facture,$souscripteur,$path,$total)
    {
        $this->facture = $facture;
        $this->souscripteur = $souscripteur;
        $this->total = $total;
        $this->path = $path;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Etat Financier '.strtoupper($this->souscripteur->user->nom).'  '.ucfirst($this->souscripteur->user->prenom).' au '. now()->format('d-m-yy'))
            ->bcc('comptabilite@medicasure.com','Comptabilite')
            ->from(config('mail.from.address'))
            ->markdown('emails.factures.recouvrement')
            ->attach(public_path($this->path), [
                'mime' => 'application/pdf',
            ]);

    }
}
