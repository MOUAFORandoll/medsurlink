<?php

namespace App\Providers;

use App\Models\ActionMotif;
use App\Models\Affiliation;
use App\Models\Allergie;
use App\Models\Antecedent;
use App\Models\Cardiologie;
use App\Models\Conclusion;
use App\Models\DossierAllergie;
use App\Models\ConsultationExamenClinique;
use App\Models\ConsultationExamenComplementaire;
use App\Models\ConsultationMedecineGenerale;
use App\Models\ConsultationMotifs;
use App\Models\ConsultationObstetrique;
use App\Models\ConsultationPrenatale;
use App\Models\ConsultationTraitement;
use App\Models\ConsultPrenExamClin;
use App\Models\ConsultPrenExamCom;
use App\Models\DossierMedical;
use App\Models\Echographie;
use App\Models\EtablissementExercice;
use App\Models\ExamenCardio;
use App\Models\ExamenClinique;
use App\Models\ExamenComplementaire;
use App\Models\File;
use App\Models\Gestionnaire;
use App\Models\Hospitalisation;
use App\Models\HospitalisationExamClin;
use App\Models\HospitalisationExamCom;
use App\Models\MedecinControle;
use App\Models\Medicament;
use App\Models\Motif;
use App\Models\Ordonance;
use App\Models\OrdonanceMedicament;
use App\Models\ParametreCommun;
use App\Models\ParametreObstetrique;
use App\Models\Patient;
use App\Models\PatientSouscripteur;
use App\Models\Praticien;
use App\Models\Profession;
use App\Models\RendezVous;
use App\Models\Resultat;
use App\Models\ResultatImagerie;
use App\Models\ResultatLabo;
use App\Models\Souscripteur;
use App\Models\Specialite;
use App\Models\Traitement;
use App\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
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
        ]);
    }
}
