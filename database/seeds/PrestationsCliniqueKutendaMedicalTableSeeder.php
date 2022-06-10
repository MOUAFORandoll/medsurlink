<?php

use \App\Models\Prestation;
use \Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use \App\Models\EtablissementExercice;
use App\Models\EtablissementPrestation;

class PrestationsCliniqueKutendaMedicalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // for scope issue
        $user = Auth::loginUsingId(129);

        // data
        $prestations = [
            [
                "nom" => "Accouchement eutocique (sans kit)",
                "prix" => "25000"
            ],
            [
                "nom" => "Accouchement normal (sans kit)",
                "prix" => "25000"
            ],
            [
                "nom" => "Aspiration utérine sous AL avec kit",
                "prix" => "3000"
            ],
            [
                "nom" => "Aspiration utérine sous AL sans kit",
                "prix" => "40000"
            ],
            [
                "nom" => "Biopsie vulve/vagin/sein/col",
                "prix" => "3000"
            ],
            [
                "nom" => "Causerie éducative",
                "prix" => "2000"
            ],
            [
                "nom" => "Chéloïdectomie sous AL",
                "prix" => "25000"
            ],
            [
                "nom" => "Cheloïdectomie sous AL inter médiane",
                "prix" => "15000"
            ],
            [
                "nom" => "Cheloïdectomie sous AL moyen nodule",
                "prix" => "10000"
            ],
            [
                "nom" => "Cheloïdectomie sous AL petit nodule",
                "prix" => "5000"
            ],
            [
                "nom" => "Circonsion sous AL sans kit",
                "prix" => "10000"
            ],
            [
                "nom" => "Circonsion sous AL avec kit",
                "prix" => "15000"
            ],
            [
                "nom" => "Curage  digitale",
                "prix" => "5000"
            ],
            [
                "nom" => "cure  Hernie + hydrocèle",
                "prix" => "60000"
            ],
            [
                "nom" => "Cure de bartholinite sous AL",
                "prix" => "25000"
            ],
            [
                "nom" => "cure de Varicocèle",
                "prix" => "30000"
            ],
            [
                "nom" => "cure Hernie Simple",
                "prix" => "30000"
            ],
            [
                "nom" => "Cure hernie sous AL",
                "prix" => "30000"
            ],
            [
                "nom" => "Cure torsion testiculaire sous AL sans kit",
                "prix" => "35000"
            ],
            [
                "nom" => "Curetage thérapeutique sous AL",
                "prix" => "20000"
            ],
            [
                "nom" => "Cystotomie sous pubienne",
                "prix" => "5000"
            ],
            [
                "nom" => "Dilatation vaginale sous AL",
                "prix" => "1500"
            ],
            [
                "nom" => "Drainage abcès du douglas",
                "prix" => "10000"
            ],
            [
                "nom" => "Drainage abcès sous AL",
                "prix" => "5000"
            ],
            [
                "nom" => "ECG ( Electro-cardiogramme)",
                "prix" => "10000"
            ],
            [
                "nom" => "Echographie abdominale",
                "prix" => "10000"
            ],
            [
                "nom" => "Echographie endovaginale",
                "prix" => "10000"
            ],
            [
                "nom" => "Echographie obstétricale",
                "prix" => "8000"
            ],
            [
                "nom" => "Echographie pelvienne",
                "prix" => "10000"
            ],
            [
                "nom" => "Echographie scrotale",
                "prix" => "15000"
            ],
            [
                "nom" => "Episiotomie 2ème dégré",
                "prix" => "10000"
            ],
            [
                "nom" => "Exérèse biopsique nodule sein sous AL",
                "prix" => "20000"
            ],
            [
                "nom" => "Exérèse condylome périnée 20/10",
                "prix" => "20000"
            ],
            [
                "nom" => "Exérèse condylome vaginal",
                "prix" => "20000"
            ],
            [
                "nom" => "Exérèse kyste mammaire",
                "prix" => "25000"
            ],
            [
                "nom" => "Exérèse kyste synovial",
                "prix" => "5000"
            ],
            [
                "nom" => "Extraction corps etranger parties molles",
                "prix" => "15000"
            ],
            [
                "nom" => "Forfait soins infirmiers gynécologie",
                "prix" => "10000"
            ],
            [
                "nom" => "Fracture fermée avec réduction deux os avant bras (Urgence)",
                "prix" => "40000"
            ],
            [
                "nom" => "Fracture fermée avec réduction Jambe/Pied (Urgence)",
                "prix" => "20000"
            ],
            [
                "nom" => "Freinotomie",
                "prix" => "10000"
            ],
            [
                "nom" => "Grand pansement",
                "prix" => "2500"
            ],
            [
                "nom" => "Incision drainage abcès du sein sous AL",
                "prix" => "10000"
            ],
            [
                "nom" => "Incision drainage abcès du sein sous AL",
                "prix" => "10000"
            ],
            [
                "nom" => "injection intra-musculaire",
                "prix" => "500"
            ],
            [
                "nom" => "Injection intramusculaire (benzathine 2,4ui inj)",
                "prix" => "500"
            ],
            [
                "nom" => "injection intraveineuse",
                "prix" => "500"
            ],
            [
                "nom" => "Kystectomie sous AL",
                "prix" => "15000"
            ],
            [
                "nom" => "Lavement évacuateur",
                "prix" => "1500"
            ],
            [
                "nom" => "lipomectomie",
                "prix" => "10000"
            ],
            [
                "nom" => "Monitoring foetal",
                "prix" => "3000"
            ],
            [
                "nom" => "Monitoring maternel",
                "prix" => "3000"
            ],
            [
                "nom" => "Pansement alcoolisé",
                "prix" => "1500"
            ],
            [
                "nom" => "Pansement avec kit",
                "prix" => "1000"
            ],
            [
                "nom" => "Pansement des brulés surface < 20 % (forfait)",
                "prix" => "10000"
            ],
            [
                "nom" => "Pansement des escares",
                "prix" => "3500"
            ],
            [
                "nom" => "pansement humide (sans kit)",
                "prix" => "1000"
            ],
            [
                "nom" => "pansement sec (sans Kit)",
                "prix" => "500"
            ],
            [
                "nom" => "Pansement sec (sans Kit)",
                "prix" => "500"
            ],
            [
                "nom" => "Ponction lombaire",
                "prix" => "2000"
            ],
            [
                "nom" => "Ponction lombaire",
                "prix" => "3000"
            ],
            [
                "nom" => "Ponction péritonéale",
                "prix" => "3000"
            ],
            [
                "nom" => "Pose de bas de contention (sans bas)",
                "prix" => "300"
            ],
            [
                "nom" => "Suture",
                "prix" => "3000"
            ],
            [
                "nom" => "Pose de sonde urinaire pour femme",
                "prix" => "2000"
            ],
            [
                "nom" => "Pose de sonde urinaire pour homme",
                "prix" => "15000"
            ],
            [
                "nom" => "Pose dispositif intrautérin",
                "prix" => "5000"
            ],
            [
                "nom" => "Pose Plâtre brachial antébrachial",
                "prix" => "20000"
            ],
            [
                "nom" => "Pose Plâtre cruro-pedieux",
                "prix" => "25000"
            ],
            [
                "nom" => "Prélèvement gynécologique",
                "prix" => "1500"
            ],
            [
                "nom" => "Soins des plaies chroniques (forfait)",
                "prix" => "15000"
            ],
            [
                "nom" => "Sonde urinaire Femme",
                "prix" => "2000"
            ],
            [
                "nom" => "Sonde urinaire Homme",
                "prix" => "2500"
            ],
            [
                "nom" => "Suture 1 plan sous AL",
                "prix" => "5000"
            ],
            [
                "nom" => "Suture 2 plans sous AL",
                "prix" => "7500"
            ],
            [
                "nom" => "Suture 3 plans sous AL",
                "prix" => "10000"
            ],
            [
                "nom" => "Suture déchirure vaginale sous AL",
                "prix" => "10000"
            ],
            [
                "nom" => "Points de sutures simples",
                "prix" => "500"
            ],
            [
                "nom" => "Toucher rectal évacuateur ( Extraction d'un Fécalome)",
                "prix" => "1000"
            ],
            [
                "nom" => "Transfusion sanguine",
                "prix" => "3000"
            ],
            [
                "nom" => "Transfusion sanguine",
                "prix" => "3000"
            ],
            [
                "nom" => "Vaccination avec PEV",
                "prix" => "1000"
            ],
            [
                "nom" => "Vaccination hors PEV",
                "prix" => "500"
            ],
            [
                "nom" => "Zonectomie sous AL",
                "prix" => "20000"
            ],
            [
                "nom" => "Gtest acte infirmier",
                "prix" => "500"
            ],
            [
                "nom" => "FILS A SUTURE ",
                "prix" => "2500"
            ],
            [
                "nom" => "FILS A SUTURE VICRYL ABSOBABLE",
                "prix" => "3000"
            ],
            [
                "nom" => "FILS A SUTURE ",
                "prix" => "1500"
            ],
            [
                "nom" => "SERUM ANTITETANIQAUE (SAT) B/10",
                "prix" => "700"
            ],
            [
                "nom" => "SUTURE 3000",
                "prix" => "3000"
            ],
            [
                "nom" => "lame de bistouri",
                "prix" => "100"
            ],
            [
                "nom" => "LAME DE BISTOURI",
                "prix" => "1000"
            ],
            [
                "nom" => "TEST CONFIRMATION HIV",
                "prix" => "3000"
            ],
            [
                "nom" => "soins pose perfusion",
                "prix" => "1000"
            ],
            [
                "nom" => "Echographie abdomino-pelvienne",
                "prix" => "12000"
            ],
            [
                "nom" => "Soins du post partum",
                "prix" => "500"
            ],
            [
                "nom" => "Soin du post partum",
                "prix" => "500"
            ],
            [
                "nom" => "incision abces simple",
                "prix" => "2000"
            ],
            [
                "nom" => "Aspirateur de mucosités",
                "prix" => "2000"
            ],
            [
                "nom" => "Episiotomie 3ème dégré",
                "prix" => "20000"
            ],
            [
                "nom" => "Accouchement gynécologue",
                "prix" => "50000"
            ],
            [
                "nom" => "pose perfusion",
                "prix" => "1000"
            ],
            [
                "nom" => "ECHOGRAPHIE PROSTATIQUE",
                "prix" => "15000"
            ],
            [
                "nom" => "ECHO PELVIENNE",
                "prix" => "10000"
            ],
            [
                "nom" => "ECHOGRAPHIE TESTICULAIRE",
                "prix" => "15000"
            ],
            [
                "nom" => "ECHOGRAPHIE ARTICULAIRE",
                "prix" => "18000"
            ],
            [
                "nom" => "HYSTERO-SONOGRAPHIE",
                "prix" => "30000"
            ],
            [
                "nom" => "ECHOGRAPHIE DES PARTIES MOLLES",
                "prix" => "12000"
            ],
            [
                "nom" => "ECHOGRAPHIE MAMMAIRE",
                "prix" => "12000"
            ],
            [
                "nom" => "ECHOGRAPHIE OCCULAIRE",
                "prix" => "12000"
            ],
            [
                "nom" => "ECHOGRAPHIE DE LA THYROIDE",
                "prix" => "12000"
            ],
            [
                "nom" => "ECHOGRAPHIE RENALE VESICALE",
                "prix" => "13000"
            ],
            [
                "nom" => "ECHOGRAPHIE TRANSFONTANELLAIRE ET DE LA MOELLE EPINIERE",
                "prix" => "18000"
            ],
            [
                "nom" => "ECHOGRAPHIE OBTETRICALE 3D",
                "prix" => "20000"
            ],
            [
                "nom" => "ECHOGRAPHIE ABDOMINO-PELVIENNE",
                "prix" => "13000"
            ],
            [
                "nom" => "ECHOGRAPHIE THORAXIQUE",
                "prix" => "15000"
            ],
            [
                "nom" => "ECHOGRAPHIE DOPPLER DES VAISSEAUX DU COU",
                "prix" => "37500"
            ],
            [
                "nom" => "ECHOGRAPHIE DOPPLER DES VEINES DES MEMBRES SUPERIEURS",
                "prix" => "30000"
            ],
            [
                "nom" => "ECHOGRAPHIE DOPPLER DES VEINES DU MEMBRES INFERIEURS",
                "prix" => "30000"
            ],
            [
                "nom" => "ECHO DOPPLER DES ARTERES DU MEMBRE SUPERIEUR",
                "prix" => "30000"
            ],
            [
                "nom" => "ECHO DOPPLER DES ARTERES DU MEMBRE INFERIEUR",
                "prix" => "30000"
            ],
            [
                "nom" => "ECHO DOPPLER DES VEINES ET DES ARTERES DU MEMBRE SUPERIEUR",
                "prix" => "54000"
            ],
            [
                "nom" => "ECHOGRAPHIE DOPPLER DES VAISSEAUX ABDOMINAUX",
                "prix" => "37500"
            ],
            [
                "nom" => "ECHO  DOPPLER DES VAISSEAUX TESTICULAIRES",
                "prix" => "27500"
            ],
            [
                "nom" => "ECHO DOPPLER DU CORDON OMBILICAL DU FŒTUS",
                "prix" => "27500"
            ],
            [
                "nom" => "MONOTORING",
                "prix" => "5000"
            ],
            [
                "nom" => "SOIN INFIRMIER JOUR ACCOUCHEMENT (AMI)",
                "prix" => "5000"
            ],
            [
                "nom" => "SOIN INFIRMER AUTRE JOUR APRES QCCOUCHEMENT",
                "prix" => "2500"
            ],
            [
                "nom" => "ECHOGRAPHIE DU GENOU",
                "prix" => "20000"
            ],
            [
                "nom" => "BANDELETTE  URINAIRE (combi 2)",
                "prix" => "500"
            ],
            [
                "nom" => "POSE SONDE URINAIRE",
                "prix" => "15000"
            ],
            [
                "nom" => "CESARienne ELECTIVE",
                "prix" => "175000"
            ],
            [
                "nom" => "CESARIENNE D'URGENCE",
                "prix" => "175000"
            ],
            [
                "nom" => "CONSULTATION ANESTHESIQUE",
                "prix" => "10000"
            ],
            [
                "nom" => "AMI (ACTES MEDICAUX INFIRMIERS)",
                "prix" => "300"
            ],
            [
                "nom" => "SUIVI MEDICAL",
                "prix" => "5000"
            ]
        ];

        // try to get kutenda medical
        $etablissement_clinique_kutanda_medical = EtablissementExercice::where('slug', 'like', '%kutenda-medical-%')->first();

        // check if found
        if (!is_null($etablissement_clinique_kutanda_medical)) {

            // map all prestations
            foreach ($prestations as $prestation) {
                // create prestation
                $prestation_created = Prestation::create([
                    'nom' => $prestation['nom'],
                    'prix' => $prestation['prix'],
                    'slug' => Str::slug($prestation['nom'], '-') . '-' . now()->timestamp,
                ]);

                // bind that prestation to kutenda medical
                EtablissementPrestation::create([
                    'etablissement_id' => $etablissement_clinique_kutanda_medical->id,
                    'prestation_id' => $prestation_created->id,
                    'prix' => $prestation_created->prix,
                    'reduction' => '0',
                    'slug' => now()->timestamp
                ]);

            }
        }

    }
}
