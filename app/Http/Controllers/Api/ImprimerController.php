<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Models\ConsultationMedecineGenerale;
use App\Models\ConsultationObstetrique;
use App\Models\DossierMedical;
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
        $signature = null;
        if (!is_null($auteur)){
            if ($auteur->auteurable_type == 'Praticien'){
                $praticien = Praticien::find($auteur->auteurable_id);
                $signature = $praticien->signature;
            }
        }

        $data = compact('consultationMedecine','signature');
        $pdf = PDF::loadView('rapport',$data);
        $path = storage_path().'/app/public/pdf/'.'Consultation-generale-'.$consultationMedecine->date_consultation.'.pdf';

        $pdf->save($path);

        return  response()->json(['name'=>'Consultation-generale-'.$consultationMedecine->date_consultation.'.pdf']);
    }

    public function obstetrique($slug){

        $this->validatedSlug($slug,'consultation_obstetriques');

        $consultationObstetrique = ConsultationObstetrique::findBySlug($slug);

        $pdf = PDF::loadView('contrat_version_imprimable',compact('consultationObstetrique'));
        return $pdf->download('consultation_obstetrique.pdf');
    }

}
