<?php

namespace App\Imports;

use App\Models\CategoriePrestation;
use App\Models\EtablissementPrestation;
use App\Models\Prestation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PrestationImport implements ToCollection,WithHeadingRow
{
    private $etablissementId = 0;

    /**
     * PrestationImport constructor.
     * @param int $etablissementId
     */
    public function __construct(int $etablissementId)
    {
        $this->etablissementId = $etablissementId;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row){
            $categorie = CategoriePrestation::whereNom($row['categorie_prestation'])->first();
            if (is_null($categorie)){
                $categorie = CategoriePrestation::create(['nom'=>$row['categorie_prestation']]);
            }
            $prestation = Prestation::whereNom($row['nom_prestation'])->where('categorie_id',$categorie->id)->first();
            if (is_null($prestation)){
                $prestation = Prestation::create([
                    'nom'=>$row['nom_prestation'],
                    'slug'=>$row['prix'],
                    'categorie_id'=>$categorie->id
                ]);
            }

            EtablissementPrestation::create([
                'prestation_id'=>$prestation->id,
                'etablissement_id'=>$this->getEtablissementId(),
                'prix'=>$row['prix'],
                'reduction'=>$row['reduction'],
            ]);

        }
    }

    /**
     * @return int
     */
    public function getEtablissementId(): int
    {
        return $this->etablissementId;
    }

    /**
     * @param int $etablissementId
     */
    public function setEtablissementId(int $etablissementId): void
    {
        $this->etablissementId = $etablissementId;
    }

}
