<?php

use Illuminate\Database\Seeder;
use App\Models\ExamenComplementaire;

class ExamenComplementaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hematologie = [
            'NFS',
            'Groupage sanguin (GS-RH)',
            'Vitesse sédimentation (VS)',
            'Electrophorèse d’Hb (E-Hb)',
        ];
        $parasitologie = [
            'Coprologie (Selles)',
            'Recherche des hémoparasites',
            'Recherche des microfilaires',
            'Skin-snip test',
            'TDR palu',
        ];
        $Hemostase = [
            'TP/INR',
            'TCA/TCK',
            'TEMPS SAIGNEMENT (TS)',
            'TEMPS COAGULATION (TC)',
            'MYELOGRAMME',
            'D-DIMÈRES'
        ];
        $biochimie = [
            'Bandelette urinaire',
            'Glycémie à jeun',
            'Combi 2',
            'G Test',
            'Urée',
            'Glucose',
            'Créatinine',
            'Alat (GPT)',
            'Asat (GOT)',
            'Ionogramme (Na K Cl Ca Mg)',
            'Ionogramme simple (Na, K, Cl)',
            'Calcium',
            'Magnésium',
            'Sodium',
            'Potassium',
            'Chlore',
            'Phosphore',
            'Acide urique',
            'Triglycérides',
            'Cholesterol total',
            'Cholesterol  HDL',
            'Cholesterol  LDL',
            'Profil lipidique',
            'Phosphatase alcaline (PAL)',
            'Hémoglobine glyquée (HbA1c)',
            'Albuminémie '
        ];
        $imunoserologie = [
            'Protéine C réactive (CRP)',
            'Antistreptolysine O (ASLO)',
            'Facteur rhumatoïde (FR)',
            'Widal & Félix sur plaque',
            'Hépatite B (Aghbs dépistage)',
            'Hépatite B confirmation',
            'Hépatite C (AcHCV dépistage)',
            'Hépatite C confirmation',
            'Hiv (dépistage)',
            'Hiv (confirmation)',
            'Chlamydia Direct',
            'Chlamydia qualitatif IgM',
            'Syphilis (Tpha/Vdrl ou RPR)',
            'Chlamydia IgM elisa',
            'Chlamydia IgG elisa',
            'Chlamydia IgG+IgM elisa',
            'Toxoplasmose IgG/IgM qualitatif',
            'Toxoplasmose IgG elisa',
            'Toxoplasmose IgM elisa',
            'Toxoplasmose IgG+IgM elisa',
            'Rubéole  IgG/IgM qualitatif',
            'Rubeole IgG  elisa',
            'Rubeole IgM elisa',
            'Rubeole IgG + IgM  elisa',
        ];
        $hormonologie = [
            'Oestradiol (E2)',
            'Testostérone',
            'Fsh',
            'Tsh',
            'Prolactine',
            'Progestérone',
            'T3 libre',
            'T4 libre',
        ];
        $marqueurstumauraux = [
            'PSA TOTAL',
            'PSA LIBRE',

        ];
        $marqueurscardiaques = [
            'NT-PRO BNP ',
            'CTNI /MYO/CKMB',
        ];
        $bacteriologie = [
            'Pcv +atb',
            'Pu +atb',
            'Pcv',
            'Pu',
            'Mycoplasme',
            'Coproculture',
            'Ecbu + atb',            
            'Spermogramme',
            'Spermoculture',
            'Pus + atb',
            'Culot urinaire',
        ];

        foreach ($hematologie as $category){
            \App\Models\ExamenComplementaire::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'HEMATOLOGIE',
            ]);
        }
        foreach ($parasitologie as $category){
            \App\Models\ExamenComplementaire::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'PARASITOLOGIE',
            ]);
        }
        foreach ($Hemostase as $category){
            \App\Models\ExamenComplementaire::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'HEMOSTASE',
            ]);
        }
        foreach ($biochimie as $category){
            \App\Models\ExamenComplementaire::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'BIOCHIMIE',
            ]);
        }
        foreach ($imunoserologie as $category){
            \App\Models\ExamenComplementaire::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'IMMUNO-SEROLOGIE',
            ]);
        }
        foreach ($hormonologie as $category){
            \App\Models\ExamenComplementaire::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'HORMONOLOGIE',
            ]);
        }
        foreach ($marqueurstumauraux as $category){
            \App\Models\ExamenComplementaire::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'MARQ. TUMORAUX',
            ]);
        }
        foreach ($marqueurscardiaques as $category){
            \App\Models\ExamenComplementaire::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'MARQ. CARDIAQUES',
            ]);
        }
        foreach ($bacteriologie as $category){
            \App\Models\ExamenComplementaire::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'BACTERIOLOGIE',
            ]);
        }
    }
}
