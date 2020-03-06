<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Models\Cardiologie;
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
                $praticiens = $praticien;
                $signature = $praticien->signature;
            }else if($auteur->auteurable_type == 'Medecin controle') {
                $medecin = MedecinControle::with('user')->find($auteur->auteurable_id);
                $praticiens = $medecin;
                $signature = $medecin->signature;
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

        $pContributeurs = Praticien::with('user')->whereIn('user_id',$cContributeurs)->get();
        $mContributeurs = MedecinControle::with('user')->whereIn('user_id',$cContributeurs)->get();

        $data = compact('consultationMedecine','signature','medecins','praticiens','mContributeurs','pContributeurs');
        $pdf = PDF::loadView('rapport',$data);
        $nom  = ucfirst($consultationMedecine->dossier->patient->user->nom);
        $prenom = is_null($consultationMedecine->dossier->patient->user->prenom) ? '' :$consultationMedecine->dossier->patient->user->prenom;
        $prenom  = ucfirst($prenom);
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
        $nom  = ucfirst($consultation->dossier->patient->user->nom);
        $prenom = is_null($consultation->dossier->patient->user->prenom) ? '' :$consultation->dossier->patient->user->prenom;
        $prenom  = ucfirst($prenom);
        $date= $consultation->date_consultation;
        $path = storage_path().'/app/public/pdf/'.'Cardiologie_'.$nom.'_'.$prenom.'_'.$date.'.pdf';
        $pdf->save($path);

        return  response()->json(['name'=>'Cardiologie_'.$nom.'_'.$prenom.'_'.$date.'.pdf']);
    }


}
