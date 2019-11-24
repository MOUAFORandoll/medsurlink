<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Models\ConsultationMedecineGenerale;
use App\Models\ConsultationObstetrique;
use App\Models\DossierMedical;
use Barryvdh\DomPDF\Facade as PDF;
use Gbrock\Table\Table;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImprimerController extends Controller
{
    use PersonnalErrors;
    public function dossier($slug){

//        $this->validatedSlug($slug,'dossier_medicals');

        $dossier = DossierMedical::findBySlug($slug);
        $data = compact('dossier');
        $pdf = PDF::loadView('rapport',$data);
        return $pdf->download('dossier.pdf');
    }

    public function generale($slug){

        $this->validatedSlug($slug,'consultation_medecine_generales');

        $consultationMedecine = ConsultationMedecineGenerale::findBySlug($slug);

        $pdf = PDF::loadView('contrat_version_imprimable',compact('consultationMedecine'));
        return $pdf->download('consultation_generale.pdf');
    }

    public function obstetrique($slug){

        $this->validatedSlug($slug,'consultation_obstetriques');

        $consultationObstetrique = ConsultationObstetrique::findBySlug($slug);

        $pdf = PDF::loadView('contrat_version_imprimable',compact('consultationObstetrique'));
        return $pdf->download('consultation_obstetrique.pdf');
    }

}
