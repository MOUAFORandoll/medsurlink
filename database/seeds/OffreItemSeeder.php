<?php

use Illuminate\Database\Seeder;

class OffreItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $urgence = [
            '1x Avis D’experts',
            '2x Consultations générales ou 1x Consultation spécialisée',
            'Examens biologiques (jusqu’à 50 EUR)',
            'Imagerie (jusqu’à 20 EUR)',
            '1 Nuit Hospitalisation ou 1x Mise en Observation (jusqu’à 15 EUR)',
            'Médicaments d’Urgence (jusqu’à 10 EUR) ',
            'Transport en Ambulance',
        ];
        $prevention = [
            '2x Avis D’experts',
            '1x Discussion pluridisciplinaire',
            '4x Consultations générales ou 2x Consultation générales à Domicile',
            '1x Consultation diététique',
            '1x Consultation spécialisée',
            'Examens biologiques (jusqu’à 150 EUR)',
            'Imagerie (jusqu’à 20 EUR)',
            'Dépistage Cancer de la Prostate',
            'Dépistage Cancer du sein',
            'Bilans Approfondis Cardiaques',
            'Dépistages Autres Cancers',
        ];
        $grossesse = [
            '1x Avis D’experts',
            '1x Discussion pluridisciplinaire',
            'Toutes Consultations générales',
            '1x Consultation diététique',
            'Consultations gynécologiques',
            'Examens biologiques du suivi',
            'Echographies de Grossesse',
            'Vitamines de Grossesse',
            'Monitoring fœtal',
            'Accouchement par Spécialistes',
            '1x Consultation pédiatre',
            'Nuits Hospitalisation Mère et Nouveau-né',
            '1er Vaccin Nouveau-né',
            ' Traitements Autres pathologies découvertes'
        ];

        foreach ($urgence as $category) {
            $result = \App\Models\Dictionnaire::create([
                'fr_description' => $category,
                'en_description' => $category,
                'reference' => 'CIM URGENCE',
            ]);
            $packages =  \App\Models\Package::where("offre_id", 1)->get();
            foreach ($packages as $package) {
                \App\Models\OffrePackageItem::create([
                    'key' => $result->id,
                    'reference' => $result->reference,
                    'package_id' => $package->id,
                    'value' => '-',
                ]);
            }
        }
        foreach ($prevention as $category) {
            $result =  \App\Models\Dictionnaire::create([
                'fr_description' => $category,
                'en_description' => $category,
                'reference' => 'CIM PREVENTION',
            ]);
            $packages =  \App\Models\Package::where("offre_id", 2)->get();
            foreach ($packages as $package) {
                \App\Models\OffrePackageItem::create([
                    'key' => $result->id,
                    'reference' => $result->reference,
                    'package_id' => $package->id,
                    'value' => '-',
                ]);
            }
        }
        foreach ($grossesse as $category) {
            $result = \App\Models\Dictionnaire::create([
                'fr_description' => $category,
                'en_description' => $category,
                'reference' => 'GROSSESSE',
            ]);
            $packages =  \App\Models\Package::where("offre_id", 3)->get();
            foreach ($packages as $package) {
                \App\Models\OffrePackageItem::create([
                    'key' => $result->id,
                    'reference' => $result->reference,
                    'package_id' => $package->id,
                    'value' => '-',
                ]);
            }
        }
    }
}
