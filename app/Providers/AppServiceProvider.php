<?php

namespace App\Providers;

use App\User;
use App\Models\File;
use App\Models\Motif;
use App\Models\Suivi;
use App\Models\Facture;
use App\Models\Patient;
use App\Models\Allergie;
use App\Models\Resultat;
use App\Models\Comptable;
use App\Models\Ordonance;
use App\Models\Praticien;
use App\Models\Antecedent;
use App\Models\Assistante;
use App\Models\Conclusion;
use App\Models\Medicament;
use App\Models\Pharmacien;
use App\Models\Profession;
use App\Models\RendezVous;
use App\Models\Specialite;
use App\Models\Traitement;
use App\Models\ActionMotif;
use App\Models\Affiliation;
use App\Models\Cardiologie;
use App\Models\Echographie;
use App\Models\ExamenCardio;
use App\Models\Gestionnaire;
use App\Models\ResultatLabo;
use App\Models\Souscripteur;
use App\Models\DossierMedical;
use App\Models\ExamenClinique;
use App\Models\Kinesitherapie;
use App\Models\DossierAllergie;
use App\Models\Hospitalisation;
use App\Models\MedecinControle;
use App\Models\ParametreCommun;
use App\Models\ResultatImagerie;
use App\Models\ConsultationMotifs;
use App\Models\ConsultPrenExamCom;
use App\Models\ConsultationFichier;
use App\Models\ConsultPrenExamClin;
use App\Models\OrdonanceMedicament;
use App\Models\PatientSouscripteur;
use App\Models\ExamenComplementaire;
use App\Models\ParametreObstetrique;
use App\Models\ConsultationPrenatale;
use App\Models\EtablissementExercice;
use App\Models\ConsultationTraitement;
use App\Models\HospitalisationExamCom;
use Illuminate\Support\Facades\Schema;
use App\Models\ConsultationObstetrique;
use App\Models\HospitalisationExamClin;
use Illuminate\Support\ServiceProvider;
use App\Models\ConsultationExamenClinique;
use App\Models\ConsultationMedecineGenerale;
use App\Models\ConsultationExamenComplementaire;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Relation::morphMap([
            'Comptable'=>Comptable::class,
            'Assistante'=>Assistante::class,
            'Pharmacien'=>Pharmacien::class,
            'Kinesitherapie'=>Kinesitherapie::class,
            'Facture'=>Facture::class,
            'RendezVous'=>RendezVous::class,
            'PatientSouscripteur'=>PatientSouscripteur::class,
            'ActionMotif'=>ActionMotif::class,
            'ExamenCardio'=>ExamenCardio::class,
            'Cardiologie'=>Cardiologie::class,
            'File'=>File::class,
            'OrdonanceMedicament'=>OrdonanceMedicament::class,
            'Ordonance'=>Ordonance::class,
            'Medicament'=>Medicament::class,
            'Motif'=>Motif::class,
            'Consultation'=>ConsultationMedecineGenerale::class,
            'Allergie'=>Allergie::class,
            'Affiliation'=>Affiliation::class,
            'Antecedent'=>Antecedent::class,
            'Conclusion'=>Conclusion::class,
            'DossierAllergie'=>DossierAllergie::class,
            'ConsultationPrenatale'=>ConsultationPrenatale::class,
            'ConsultationObstetrique'=>ConsultationObstetrique::class,
            'ConsultationExamenClinique'=>ConsultationExamenClinique::class,
            'ConsultationExamenComplementaire'=>ConsultationExamenComplementaire::class,
            'ConsultationMotif'=>ConsultationMotifs::class,
            'ConsultationMedecineGenerale'=>ConsultationMedecineGenerale::class,
            'ConsultationTraitement'=>ConsultationTraitement::class,
            'ConsultPrenExamClin'=>ConsultPrenExamClin::class,
            'ConsultPrenExamCom'=>ConsultPrenExamCom::class,
            'DossierMedical'=>DossierMedical::class,
            'Echographie'=>Echographie::class,
            'EtablissementExercice'=>EtablissementExercice::class,
            'ExamenClinique'=>ExamenClinique::class,
            'ExamenComplementaire'=>ExamenComplementaire::class,
            'Gestionnaire'=>Gestionnaire::class,
            'Hospitalisation'=>Hospitalisation::class,
            'HospitalisationExamCom'=>HospitalisationExamCom::class,
            'HospitalisationExamClin'=>HospitalisationExamClin::class,
            'MedecinControle'=>MedecinControle::class,
            'ParametreCommun'=>ParametreCommun::class,
            'ParametreObstetrique'=>ParametreObstetrique::class,
            'Patient'=>Patient::class,
            'Praticien'=>Praticien::class,
            'Profession'=>Profession::class,
            'ResultatLabo'=>ResultatLabo::class,
            'ResultatImagerie'=>ResultatImagerie::class,
            'Souscripteur'=>Souscripteur::class,
            'Specialite'=>Specialite::class,
            'Traitement'=>Traitement::class,
            'Suivi'=>Suivi::class,
            'ConsultationFichier'=>ConsultationFichier::class
        ]);
    }
}
