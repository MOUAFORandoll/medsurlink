<?php

use App\Models\ConsultationType;
use Illuminate\Database\Seeder;

class ConsultationTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newTypeConsultation = [
            'Obstétrique',
            'Prenatale',
            'Médecine Générale',
            'Cardiologique',
            'Dermatologique',
            'Endocrinologique',
            'Gastroentérologique',
            'Geriatrique',
            'Hématologique',
            'Medicine Interne',
            'Néphrologique',
            'Neurologique',
            'Ophtalmologique',
            'Oncologique',
            'Oto-rhino-laryngologique',
            'Pédiatrique',
            'Pneumologique',
            'Psychiatrique',
            'Rhumatologique',
            'Stomatologique',
        ];

        foreach ($newTypeConsultation as $item) {
            ConsultationType::create([
                'profession_id' => 3,
                'name' => $item,
                'description' => null,
                'slug' => $item . '-' . now()->timestamp,
            ]);
        }

    }
}
