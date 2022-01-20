<?php

use Illuminate\Database\Seeder;

class AnamnesesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $general = [
            'Fièvre',
            'Asthénie',
            'Sueurs nocturnes',
            'Transpiration',
            'Prise de poids',
            'Perte de poids',
        ];
        $teteOrl = [
            'Rhinorrhée',
            'Otorrhée',
            'Otalgie',
            'Saignement du nez',
            'Baisse de l\'audition',
            'Acouphènes',
            'Diminution du goût',
            'Baisse de la vue',
            'Vision floue',
            'Mouches volantes devant les yeux',
            'Diplopie',
            'Douleur dentaire',
            'Odynophagie'
        ];
        $cardio = [
            'Douleur thoracique',
            'Palpitations',
            'Dyspnée',
            'Toux'
        ];
        $pulmonaire = [
            'Dyspnée',
            'Toux',
            'Douleur thoracique',
            'Expectoration',
            'Hémoptysie',
            'Tabagisme'
        ];
        $gastroIntestinal = [
            'Nausée',
            'Vomissement',
            'Douleur abdominale',
            'Ballonnement',
            'Selles dures',
            'Selles moles',
            'Rectorragies',
            'Méléna',
            'Dysphagie',
            'Perte d\'appétit',
            'Perte involontaire de selles'
        ];
        $gynécologique = [
            'Nycturie',
            'Pollakiurie',
            'Urgenturie',
            'Brûlure mictionnelle',
            'Douleur sus-pubienne',
            'Hématurie',
            'Miction en 2 temps',
            'Perte invonlontaire d\'urine',
            'Ménorragies',
            'Métrorragies'
        ];
        $osteoarticulaire = [
            'Douleur musculaire',
            'Douleur osseuse',
            'Douleur articulaire'
        ];
        $neurologique = [
            'Vertiges',
            'Céphalées',
            'Oublies régulières',
            'Paresthésie',
            'Parésie',
            'Dysarthrie',
            'Malaise',
            'Perte de connaissance',
            'Trouble à la marche'
        ];
        $dermatologique = [
            'Prurit',
            'Tâches',
            'Eruptions cutanées',
            'Plaies'
        ];
        $psychiatrique = [
            'Moral bas',
            'Humeur dépressive',
            'Anxiété',
            'Angoisse',
            'Rumination',
            'Maltraitance',
            'Abus',
            'Viol'
        ];
        foreach ($general as $category){
            \App\Models\Anamnese::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'Général',
            ]);
        }
        foreach ($teteOrl as $category){
            \App\Models\Anamnese::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'Tête et ORL',
            ]);
        }
        foreach ($cardio as $category){
            \App\Models\Anamnese::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'Cardio-vasculaire',
            ]);
        }
        foreach ($pulmonaire as $category){
            \App\Models\Anamnese::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'Pulmonaire',
            ]);
        }
        foreach ($gastroIntestinal as $category){
            \App\Models\Anamnese::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'Gastro-intestinal',
            ]);
        }
        foreach ($gynécologique as $category){
            \App\Models\Anamnese::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'Uro-génital / gynécologique',
            ]);
        }
        foreach ($osteoarticulaire as $category){
            \App\Models\Anamnese::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'Ostéo-articulaire',
            ]);
        }
        foreach ($neurologique as $category){
            \App\Models\Anamnese::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'Neurologique',
            ]);
        }
        foreach ($dermatologique as $category){
            \App\Models\Anamnese::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'Dermatologique',
            ]);
        }
        foreach ($psychiatrique as $category){
            \App\Models\Anamnese::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'Psychiatrique',
            ]);
        }
    }
}
