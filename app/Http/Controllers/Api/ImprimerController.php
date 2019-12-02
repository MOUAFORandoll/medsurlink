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
use Illuminate\Support\Facades\Storage;

class ImprimerController extends Controller
{
    use PersonnalErrors;
    public function dossier($slug){

//        $this->validatedSlug($slug,'dossier_medicals');

        $dossier = DossierMedical::findBySlug($slug);
        $data = compact('dossier');
        $pdf = PDF::loadView('rapport',$data);
        return $pdf->download('dossier.pdf');

        $pdf = PDF::loadView('pdf.invoice', $data);

        Storage::put('public/pdf/invoice.pdf', $pdf->output());

        $path = public_path().'/storage/pdf/invoice.pdf';
        return response()->file($path);
//        return $pdf->download('invoice.pdf');
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
