<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NouvelAffiliation extends Mailable
{
    use Queueable, SerializesModels;

    public $patient_nom, $patient_prenom, $patient_telehone, $plaintes, $niveau_urgence, $contact_nom, $contact_prenom, $contact_phone, $typeSouscription, $paye_par_affilie, $souscripteur;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($patient_nom, $patient_prenom, $patient_telehone, $plaintes, $niveau_urgence, $contact_nom, $contact_prenom, $contact_phone, $typeSouscription, $paye_par_affilie, $souscripteur)
    {
        $this->patient_nom = $patient_nom;
        $this->patient_prenom = $patient_prenom;
        $this->patient_telehone = $patient_telehone;
        $this->plaintes = $plaintes;
        $this->niveau_urgence = $niveau_urgence;
        $this->contact_nom = $contact_nom;
        $this->contact_prenom = $contact_prenom;
        $this->contact_phone = $contact_phone;
        $this->typeSouscription = $typeSouscription;
        $this->paye_par_affilie = $paye_par_affilie;
        $this->souscripteur = $souscripteur;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from(config('mail.from.address'))->subject("Nouvelle affiliation")
                ->markdown('emails.Souscripteur.envoiNotificationAffiliation');
    }
}
