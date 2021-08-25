<?php

use Illuminate\Database\Seeder;

class ExamenClinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $general = [
            'Bon état général',
            'Etat général diminué',
            'Etat général altéré',
            'Normohydraté',
            'Normocoloré'
        ];

        $teteOrl = [
            'Rhinite',
            'Bouchon de cérumen',
            'Conduit auditif érythémateux',
            'Tympan bombé',
            'Congestion nasale',
            'Ecoulement nasal postérieur',
            'Gorge érythémateuse',
            'Plaque blanchâtre sur la gorge',
            'Gorge purulente',
            'Hygiène buccale mauvaise',
            'Langue framboise',
            'Langue blanchâtre',
            'Aphtose',
            'Ptosis de la paupière',
            'Adénopathies cervicales',
        ];

        $cardioVasculaire = [
            'Arythmie',
            'Souffle cardiaque',
            'Souffle carotidien',
            'Souffle abdominal',
            'Reflux hépato jugulaire',
            'Turgescence jugulaire',
            'Œdème des membres inférieurs',
            'Temps de recoloration > 3 secondes',
            'Pouls non palpés',
            'Frottement péricardique',
            'Circulation collatérale MI',
            'Circulation collatérale abdominale',
            'Caput medusa',
            'Angiomes stellaires',
            'Pouls paradoxal',
            'Asymétrie de pouls',
            'Mollet dure et douloureux',
            'Signe de Homans positif'
        ];
        $pulmonaire = [
            'Bruits bronchiques',
            'Sibilances',
            'Ronchi',
            'Crépitants',
            'Frottement pleural',
            'Diminution du fremitus vocal',
            'Matité à la percussion'
        ];
        $gastroIntestinal = [
            'Sensibilité à la palpation',
            'Défence',
            'Pléthorique',
            'péristaltisme accéléré',
            'Péristaltisme ralenti',
            'Absence de péristaltisme',
            'Murphy positif',
            'Psoïtis positif',
            'Rebound positif',
            'Ascite',
            'Hépatomégalie',
            'Splénomégalie'
        ];
        $gynecologique = [
            'Loge rénale douloureuse',
            'Kidney push positif',
            'Leucorrhées'
        ];
        $osteoarticulaire = [
            'Pectus excavatum',
            'Douleur à la mobilisation',
            'Douleur à la palpation',
            'Déformation',
            'Lasègue positif',
            'Lasègue controlatéral positif',
            'Signe dela sonnette positif',
            'Lasègue inversé positif'
        ];
        $neurologique = [
            'Score de Glasgow',
            'Anisocorie',
            'Pupilles aréactives',
            'Absence de réflex d\'accommodation',
            'Aphasie',
            'Dysarthrie',
            'Romberg positif',
            'Présence de nystagmus',
            'Fukuda positif',
            'Head impulse tes positif',
            'Barré non tenu',
            'Prèsence de latéralisation',
            'Nuque rigide',
            'Signe de kernig positif',
            'Brudzinski positif',
            'Adiadococinésie',
            'ROT vif',
            'ROT absents',
            'Réflexe cutané plantaire positif',
            'Epreuve doigt-nez positive',
            'Perte de force',
            'Déficit sensitif',
            'Paire crânienne 1 pathologique',
            'Paire crânienne 2 pathologique',
            'Paire crânienne 3 pathologique',
            'Paire crânienne 4 pathologique',
            'Paire crânienne 5 pathologique',
            'Paire crânienne 6 pathologique',
            'Paire crânienne 7 pathologique',
            'Paire crânienne 8 pathologique',
            'Paire crânienne 9 pathologique',
            'Paire crânienne 10 pathologique',
            'Paire crânienne 11 pathologique',
            'Paire crânienne 12 pathologique',
        ];
        $dermatologique = [
            'Desquamation',
            'Sécheresse cutanée',
            'Macules',
            'Papules',
            'Plaies',
            'Brûlure',
            'Erythème',
        ];
        $psychiatrique = [
            'Anxiété',
            'Angoisse',
            'Rumination',
            'Idées délirantes',
            'Idées suicidaires',
            'Idéation persécutoire',
        ];

        foreach ($general as $category){
            \App\Models\ExamenClinic::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'Général',
            ]);
        }
        foreach ($teteOrl as $category){
            \App\Models\ExamenClinic::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'Tête et ORL',
            ]);
        }
        foreach ($cardioVasculaire as $category){
            \App\Models\ExamenClinic::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'Cardio-vasculaire',
            ]);
        }
        foreach ($pulmonaire as $category){
            \App\Models\ExamenClinic::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'Pulmonaire',
            ]);
        }
        foreach ($gastroIntestinal as $category){
            \App\Models\ExamenClinic::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'Gastro-intestinal',
            ]);
        }
        foreach ($gynecologique as $category){
            \App\Models\ExamenClinic::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'Uro-génital / gynécologique',
            ]);
        }
        foreach ($osteoarticulaire as $category){
            \App\Models\ExamenClinic::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'Ostéo-articulaire',
            ]);
        }
        foreach ($neurologique as $category){
            \App\Models\ExamenClinic::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'Neurologique',
            ]);
        }
        foreach ($dermatologique as $category){
            \App\Models\ExamenClinic::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'Dermatologique',
            ]);
        }
        foreach ($psychiatrique as $category){
            \App\Models\ExamenClinic::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'Psychiatrique',
            ]);
        }
    }
}
