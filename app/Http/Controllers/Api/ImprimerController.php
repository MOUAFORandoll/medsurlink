<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Models\Cardiologie;
use App\Models\CompteRenduOperatoire;
use App\Models\ConsultationMedecineGenerale;
use App\Models\ConsultationObstetrique;
use App\Models\DossierMedical;
use App\Models\Facture;
use App\Models\FactureAvis;
use App\Models\Hospitalisation;
use App\Models\Kinesitherapie;
use App\Models\MedecinControle;
use App\Models\Praticien;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
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

        $consultationMedecine = ConsultationMedecineGenerale::with('operationables.contributable','files')->whereSlug($slug)->first();

        $auteur = getAuthor("ConsultationMedecineGenerale",$consultationMedecine->id,"create");
        $updateAuteurs = getUpdatedAuthor("ConsultationMedecineGenerale",$consultationMedecine->id,"update");
        $signature = null;
        $medecins = [];
        $praticiens = new Praticien();
        $auteurs = [];
        if (!is_null($auteur)){
            if ($auteur->auteurable_type == 'Praticien'){
                $praticien = Praticien::with('user')->find($auteur->auteurable_id);
                $praticiens = $praticien ?? '';
                $signature = $praticien->signature ?? '';
            }else if($auteur->auteurable_type == 'Medecin controle') {
                $medecin = MedecinControle::with('user')->find($auteur->auteurable_id);
                $praticiens = $medecin ?? '';
                $signature = $medecin->signature ?? '';
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
        //Recuperation des contributeurs de la consultation
        $cContributeurs = [];
        foreach($consultationMedecine->operationables as $operationable){
            array_push($cContributeurs,$operationable['contributable']['id']);
        }

        $pContributeurs = Praticien::with('user')->whereIn('user_id',$cContributeurs)->latest()->get();
        $mContributeurs = MedecinControle::with('user')->whereIn('user_id',$cContributeurs)->latest()->get();

        if(isJSON($consultationMedecine->examen_complementaire)){
            $examen_complementaire = _group_by(json_decode($consultationMedecine->examen_complementaire, true),"reference");
        }else if(is_array($consultationMedecine->examen_complementaire)){
            $examen_complementaire = _group_by($consultationMedecine->examen_complementaire,"reference");
        }else if(is_string($consultationMedecine->complementaire)){
            $complementaire = $consultationMedecine->complementaire;
        }else{
            $examen_complementaire = null;
        }


        if(isJSON($consultationMedecine->examen_clinique)){
            // dd($consultationMedecine->examen_clinique);
            $examen_clinique = _group_by(json_decode($consultationMedecine->examens, true),"reference");
        }else if(is_array($consultationMedecine->examens)){
            $examen_clinique = _group_by($consultationMedecine->examens,"reference");
        }else if(is_string($consultationMedecine->examens)){
            $examen_clinique = $consultationMedecine->examen_clinique;
            // dd($examen_clinique);
        }else{
            $examen_clinique = $consultationMedecine->examens;
        }
        // dd($consultationMedecine);

        if(!is_null($consultationMedecine->examens)){
           $examen_clinique = _group_by(is_array($consultationMedecine->examens)?$consultationMedecine->examens:json_decode($consultationMedecine->examens, true),"reference");
        }

        if(!is_null($consultationMedecine->anamneses)){
          $anamneses = _group_by(is_array($consultationMedecine->anamneses)?$consultationMedecine->anamneses:json_decode($consultationMedecine->anamneses, true),"reference");
        }else{
            $anamneses = null;
        }

        if(!is_null($consultationMedecine->anamese)){
            $anamese = $consultationMedecine->anamese;
        }else{
            $anamese = $consultationMedecine->anamese;
        }

        if(!is_null($consultationMedecine->complementaire)){
            $complementaire = $consultationMedecine->complementaire;
        }else{
            $complementaire = $consultationMedecine->complementaire;
        }



        // if(is_string($consultationMedecine->anamneses)){
        //     $anamneses = $consultationMedecine->anamneses;
        // }else{
        //     $anamneses = $consultationMedecine->anamneses;
        // }
        // dd($consultationMedecine);

        if(!is_null($consultationMedecine->diasgnostic)){
          $diasgnostic = is_array($consultationMedecine->diasgnostic)?$consultationMedecine->diasgnostic:json_decode($consultationMedecine->diasgnostic, true);
        }else{
            $diasgnostic = null;
        }

        $data = compact('consultationMedecine','signature','medecins','praticiens','mContributeurs','pContributeurs','examen_complementaire','examen_clinique','anamneses','diasgnostic','anamese','complementaire');
        $pdf = PDF::loadView('rapport',$data);

        $nom  = patientLastName($consultationMedecine);
        $prenom = patientFirstName($consultationMedecine);
        $date= $consultationMedecine->date_consultation;

        $path = storage_path().'/app/public/pdf/'.'Generale_'.$nom.'_'.$prenom.'_'.$date.'.pdf';
        $pdf->save($path);

        return  response()->json(['name'=>'Generale_'.$nom.'_'.$prenom.'_'.$date.'.pdf']);
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

    public function cardiologie($slug){
        $this->validatedSlug($slug,'cardiologies');

        $consultation = Cardiologie::with([
            'operationables.contributable',
            'dossier.resultatsLabo',
            'dossier.hospitalisations',
            'dossier.consultationsObstetrique',
            'dossier.consultationsMedecine',
            'dossier.resultatsImagerie',
            'dossier.allergies',
            'dossier.antecedents',
            'dossier.traitements',
            'dossier.cardiologies',
            'actions.motifs',
            'parametresCommun',
            'etablissement',
            'files',
            'examenCardios'
        ])->whereSlug($slug)->first();
        $consultation->updateConsultationCardiologique();
        $auteur = getAuthor("Cardiologie",$consultation->id,"create");
        $updateAuteurs = getUpdatedAuthor("Cardiologie",$consultation->id,"update");

        //Détermination de celui qui a généré le rapport initial
        $generateur = null;
        if (!is_null($auteur)){
            if ($auteur->auteurable_type == 'Praticien'){
                $praticien = Praticien::with('user')->find($auteur->auteurable_id);
                $generateur = $praticien;
            }else if($auteur->auteurable_type == 'Medecin controle') {
                $medecin = MedecinControle::with('user')->find($auteur->auteurable_id);
                $generateur = $medecin;
            }
        }

        //Détermination de deux qui ont revisité le rapport
        $auteurs = [];
        $revisiteurs = [];
        foreach ($updateAuteurs as $item){
            if ($item->auteurable_id != $auteur->auteurable_id){
                if (!in_array($item->auteurable_id,$auteurs)){
                    if ($item->auteurable_type == 'Medecin controle'){
                        $medecin = MedecinControle::with('user')->find($item->auteurable_id);
                        array_push($revisiteurs,$medecin);
                    }
                    array_push($auteurs,$item->auteurable_id);
                }
            }
        }

        $data = compact('consultation','generateur','revisiteurs');
        $pdf = PDF::loadView('rapport.cardiologie',$data);
        $nom  = patientLastName($consultation);
        $prenom = patientFirstName($consultation);
        $date= $consultation->date_consultation;
        $path = storage_path().'/app/public/pdf/'.'Cardiologie_'.$nom.'_'.$prenom.'_'.$date.'.pdf';
        $pdf->save($path);

        return  response()->json(['name'=>'Cardiologie_'.$nom.'_'.$prenom.'_'.$date.'.pdf']);
    }

    public function hospitalisation($slug){
        $this->validatedSlug($slug,'hospitalisations');

        $hospitalisation = Hospitalisation::with([
            'dossier',
            'motifs',
            'etablissement',
        ])->whereSlug($slug)->first();

        $hospitalisation->updateHospitalisation();
        $auteur = getAuthor("Hospitalisation",$hospitalisation->id,"create");
        $updateAuteurs = getUpdatedAuthor("Hospitalisation",$hospitalisation->id,"update");

        //Détermination de celui qui a généré le rapport initial
        $generateur = null;
        if (!is_null($auteur)){
            if ($auteur->auteurable_type == 'Praticien'){
                $praticien = Praticien::with('user')->find($auteur->auteurable_id);
                $generateur = $praticien;
            }else if($auteur->auteurable_type == 'Medecin controle') {
                $medecin = MedecinControle::with('user')->find($auteur->auteurable_id);
                $generateur = $medecin;
            }
        }

        //Détermination de deux qui ont revisité le rapport
        $auteurs = [];
        $revisiteurs = [];
        foreach ($updateAuteurs as $item){
            if ($item->auteurable_id != $auteur->auteurable_id){
                if (!in_array($item->auteurable_id,$auteurs)){
                    if ($item->auteurable_type == 'Medecin controle'){
                        $medecin = MedecinControle::with('user')->find($item->auteurable_id);
                        array_push($revisiteurs,$medecin);
                    }
                    array_push($auteurs,$item->auteurable_id);
                }
            }
        }

        $data = compact('hospitalisation','generateur','revisiteurs');
        $pdf = PDF::loadView('rapport.hospitalisation',$data);
        $nom  = patientLastName($hospitalisation);
        $prenom = patientFirstName($hospitalisation);
        $date= $hospitalisation->date_entree;
        $path = storage_path().'/app/public/pdf/'.'Hospitalisation_'.$nom.'_'.$prenom.'_'.$date.'.pdf';
        $pdf->save($path);

        return  response()->json(['name'=>'Hospitalisation_'.$nom.'_'.$prenom.'_'.$date.'.pdf']);
    }

    public function factureDefinitive($slug){
        $this->validatedSlug($slug,'factures');

        $facture = Facture::whereSlug($slug)->first();
        $total = 0;
        foreach($facture->prestations as $item){
            $total += $item->prix;
        }
        $data = compact('facture','total');
        $pdf = PDF::loadView('facture.definitive',$data);
        $nom  = patientLastName($facture);
        $prenom = patientFirstName($facture);
        $date= $facture->date_facturation;
        $path = storage_path().'/app/public/pdf/'.'Facture_'.$nom.'_'.$prenom.'_'.$date.'.pdf';
        $pdf->save($path);

        return  response()->json(['name'=>'Facture_'.$nom.'_'.$prenom.'_'.$date.'.pdf']);
    }

    public function factureAvisDefinitive($slug){
        $this->validatedSlug($slug,'facture_avis');

        $facture = FactureAvis::whereSlug($slug)->first();
        $total = 0;
        foreach($facture->factureDetail as $item){
            $total += $item->total_montant;
        }
        $data = compact('facture','total');
        $pdf = PDF::loadView('facture.facture_avis',$data);
        $nom  = patientLastName($facture);
        $prenom = patientFirstName($facture);
        $date= $facture->date_facturation;
        $path = storage_path().'/app/public/pdf/'.'Facture_'.$nom.'_'.$prenom.'_'.$date.'.pdf';
        $pdf->save($path);

        return  response()->json(['name'=>'Facture_'.$nom.'_'.$prenom.'_'.$date.'.pdf']);
    }

    public function factureProforma($slug){
        $this->validatedSlug($slug,'factures');

        $facture = Facture::whereSlug($slug)->first();

        $data = compact('facture');
        $pdf = PDF::loadView('facture.proforma',$data);
        $nom  = patientLastName($facture);
        $prenom = patientFirstName($facture);
        $date= $facture->date_facturation;
        $path = storage_path().'/app/public/pdf/'.'Facture_'.$nom.'_'.$prenom.'_'.$date.'.pdf';
        $pdf->save($path);

        return  response()->json(['name'=>'Facture_'.$nom.'_'.$prenom.'_'.$date.'.pdf']);
    }

    public function compteRendu($slug){

        $this->validatedSlug($slug,'compte_rendu_operatoires');

        $compteRendu = CompteRenduOperatoire::whereSlug($slug)->first();
        $data = compact('compteRendu');
        $pdf = PDF::loadView('rapport.compte_rendu',$data);
        //dd($compteRendu->etablissement);
        $nom  = patientLastName($compteRendu);
        $prenom = patientFirstName($compteRendu);
        $date= formatRapportDate($compteRendu->date_intervention);
        $path = storage_path().'/app/public/pdf/'.'Compte_rendu_'.$nom.'_'.$prenom.'_'.$date.'.pdf';
        $pdf->save($path);
        return  response()->json(['name'=>'Compte_rendu_'.$nom.'_'.$prenom.'_'.$date.'.pdf']);
    }

    public function kinesitherapie($slug){

        $this->validatedSlug($slug,'kinesitherapies');

        $kinesitherapie = Kinesitherapie::whereSlug($slug)->first();

        //Recuperation des contributeurs de la consultation
        $cContributeurs = [];
        foreach($kinesitherapie->operationables as $operationable){
            array_push($cContributeurs,$operationable['contributable']['id']);
        }

        $pContributeurs = Praticien::with('user')->whereIn('user_id',$cContributeurs)->latest()->get();
        $mContributeurs = MedecinControle::with('user')->whereIn('user_id',$cContributeurs)->latest()->get();
        $updateAuteurs = getUpdatedAuthor("Kinesitherapie",$kinesitherapie->id,"update");
        $medecins = [];
        $auteurs = [];
        $praticien = Praticien::where('user_id',$kinesitherapie->creator)->first();
        if ($praticien){
            $praticiens = $praticien;
            $signature = $praticien->signature;
        }else{
            $medecin = MedecinControle::where('user_id',$kinesitherapie->creator)->first();
            $praticiens = $medecin;
            $signature = $medecin->signature;
        }

        foreach ($updateAuteurs as $item){
            if ($item->auteurable_id != $kinesitherapie->creator){
                if (!in_array($item->auteurable_id,$auteurs)){
                    if ($item->auteurable_type == 'Medecin controle'){
                        $medecin = MedecinControle::with('user')->find($item->auteurable_id);
                        array_push($medecins,$medecin);
                    }
                    array_push($auteurs,$item->auteurable_id);
                }
            }
        }
        $data = compact('kinesitherapie','pContributeurs','mContributeurs','medecins','praticiens','signature');
        $pdf = PDF::loadView('rapport.kinesitherapie',$data);
        $nom  = patientLastName($kinesitherapie);
        $prenom = patientFirstName($kinesitherapie);
        $date= formatRapportDate($kinesitherapie->date_consultation);
        $path = storage_path().'/app/public/pdf/'.'Kinesitherapie_'.$nom.'_'.$prenom.'_'.$date.'.pdf';
        $pdf->save($path);
        return  response()->json(['name'=>'Kinesitherapie_'.$nom.'_'.$prenom.'_'.$date.'.pdf']);
    }

}
