<?php

use Illuminate\Database\Seeder;

class OffreUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            "1x Consultation d'Analyse Médicale avant la prise en charge globale",
            '1x Discussion pluridisciplinaire avec les professionnels de santé de la diaspora et du pays',
            "Transparence totale dans les actions de prise en charge médicale",
            "Etude de cas complexes de santé par un collège de spécialistes à travers le monde",
            "Rappel des rendez-vous médicaux",
            "Accès à vos rapports médicaux en temps réel et 24/7 en ligne, à vie", "Avis sur votre santé même si vous résidez à l'étranger"
        ];

        $result =  \App\Models\Offre::create([
            'description_fr' => "CONTRAT D'INTERMEDIATION MEDICALE",
            'description_en' => "MEDICAL INTERMEDIATION CONTRACT",
            'slug' => "cim",
            'status' => true,

        ]);
        $result->save();

        $offre_package1 =  \App\Models\Package::create([
            'description_fr' => "CIM Semi-Annuel",
            'description_en' => "CIM Half-yearly",
            "offre_id" => 4,
            "montant" =>
            5000,


        ]);
        $offre_package1->save();

        $offre_package2 =  \App\Models\Package::create([
            'description_fr' => "CIM Annuelle",
            'description_en' => "CIM Annual",
            "offre_id" => 4,
            "montant" =>
            15000,


        ]);
        $offre_package2->save();
        foreach ($services as $category) {
            $resultD = \App\Models\Dictionnaire::create([
                'fr_description' => $category,
                'en_description' => $category,
                'reference' => 'cim',
            ]);
            $resultD->save();

            $packages =  \App\Models\Package::where("offre_id", 4)->get();
            foreach ($packages as $package) {
                \App\Models\OffrePackageItem::create([
                    'key' => $resultD->id,
                    'reference' => $resultD->reference,
                    'package_id' => $package->id,
                    'value' => 'oui',
                ]);
            }
        }
    }
}
