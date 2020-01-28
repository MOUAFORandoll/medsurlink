<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Models\ConsultationMedecineGenerale;
use App\Models\ConsultationObstetrique;
use App\Models\DossierMedical;
use App\Models\MedecinControle;
use App\Models\Praticien;
use Barryvdh\DomPDF\Facade as PDF;
use Gbrock\Table\Table;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ImprimerController extends Controller
{
    use PersonnalErrors;
    public function dossier($slug){

        $this->validatedSlug($slug,'dossier_medicals');

        $dossier = DossierMedical::findBySlug($slug);
        $data = compact('dossier');
        $pdf = PDF::loadView('rapport',$data);

        $path = 'public/pdf/'.$dossier->numero_dossier.'.pdf';

        Storage::put($path, $pdf->output());
        return  response()->json(['name'=>$dossier->numero_dossier.".pdf"]);
    }

    public function generale($slug){
        $this->validatedSlug($slug,'consultation_medecine_generales');

        $consultationMedecine = ConsultationMedecineGenerale::findBySlug($slug);

        $auteur = getAuthor("ConsultationMedecineGenerale",$consultationMedecine->id,"create");
        $updateAuteurs = getUpdatedAuthor("ConsultationMedecineGenerale",$consultationMedecine->id,"update");
        $signature = null;
        $medecins = [];
        $praticiens = new Praticien();
        $auteurs = [];
        if (!is_null($auteur)){
            if ($auteur->auteurable_type == 'Praticien'){
                $praticien = Praticien::with('user')->find($auteur->auteurable_id);
                $praticiens = $praticien;
                $signature = $praticien->signature;
            }
        }
        foreach ($updateAuteurs as $item){
            if ($item->auteurable_id != $auteur->auteurable_id){
                if (!in_array($item->auteurable_id,$auteurs)){
                    if ($item->auteurable_type == 'Medecin controle'){
                        $medecin = MedecinControle::with('user')->find($item->auteurable_id);
                        array_push($medecins,$medecin);
                    }
                    array_push($auteurs,$item->auteurable_id);
                }
            }
        }
        $data = compact('consultationMedecine','signature','medecins','praticiens');
        $pdf = PDF::loadView('rapport',$data);

        $nom  = ucfirst($consultationMedecine->dossier->patient->user->nom);
        $prenom  = ucfirst($consultationMedecine->dossier->patient->user->prenom);
        $date= $consultationMedecine->date_consultation;

        $path = storage_path().'/app/public/pdf/'.'Generale_'.$nom.' '.$prenom.'_'.$date.'.pdf';

        $pdf->save($path);

        return  response()->json(['name'=>'Generale_'.$nom.' '.$prenom.'_'.$date.'.pdf']);
    }

    public function obstetrique($slug){

        $this->validatedSlug($slug,'consultation_obstetriques');

        $consultationObstetrique = ConsultationObstetrique::findBySlug($slug);

        $pdf = PDF::loadView('contrat_version_imprimable',compact('consultationObstetrique'));

//        $nom  = ucfirst($consultationMedecine->dossier->patient->user->nom);
//        $prenom  = ucfirst($consultationMedecine->dossier->patient->user->prenom);
//        $date= $consultationMedecine->date_consultation;

//        $path = storage_path().'/app/public/pdf/'.'Obstetrique'.$nom.' '.$prenom.'_'.$date.'.pdf';
        return $pdf->download('consultation_obstetrique.pdf');
    }

}
