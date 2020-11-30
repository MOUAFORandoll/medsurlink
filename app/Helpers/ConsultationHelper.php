<?php

use App\Models\ConsultationMedecineGenerale;
use App\Models\Contributeurs;
use App\Models\EtablissementExercice;
use App\Models\EtablissementExercicePatient;
use App\Models\RendezVous;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\PersonnalErrors;

if(!function_exists('addContributors')) {
    /**
     * Définit les contributeurs d'une consultation
     * @param $contributeurs
     * @param $consultation
     * @param $typeOperation
     */
    function addContributors($contributeurs, $consultation, $typeOperation)
    {
        $contributeurs = explode(",", $contributeurs);
        if (!is_null($contributeurs)) {
            foreach ($contributeurs as $contributeur) {
                if (strlen($contributeur >0)){
                    $nouveauContributeur = Contributeurs::create([
                        'contributable_id' => $contributeur,
                        'contributable_type' => 'App\User',
                        'operationable_id' => $consultation->id,
                        'operationable_type' => $typeOperation

                    ]);
                }
            }
        }
    }
}

if(!function_exists('uploadConsultationFile')) {
    /**
     * Upload les fichier d'une consultation et les associes à la consultation en question
     * @param $documents
     * @param $consultation
     * @param $typeConsultation
     */
    function uploadConsultationFile($documents, $consultation, $typeConsultation)
    {
        foreach ($documents as $document){
            $path = $document->storeAs('public/DossierMedicale/' . $consultation->dossier->numero_dossier . '/'.$typeConsultation.''. $consultation->id,
                $document->getClientOriginalName());

            $file = str_replace('public/','',$path);

            $file = \App\Models\File::create([
                'fileable_type'=>$typeConsultation,
                'fileable_id'=>$consultation->id,
                'nom'=>$document->getClientOriginalName(),
                'extension'=>$document->getClientOriginalExtension(),
                'chemin'=>$file,
            ]);


        }
    }
}

if(!function_exists('bookingAppointment')) {
    /**
     * Enregistre un rdv
     * @param $consultation
     * @param $typeConsultation
     * @param $motifRdv
     * @param $dateRdv
     * @param $praticien_id
     */
    function bookingAppointment($consultation, $typeConsultation, $motifRdv, $dateRdv, $praticien_id)
    {
        if (!is_null($dateRdv) ){
            if (strlen($dateRdv) >0 && $dateRdv != 'null' &&  $dateRdv != 'Invalid date' ){
                if ($motifRdv == 'null'){
                    $motifRdv = 'Rendez vous de la consultation '.$typeConsultation.' du '.$consultation->date_consultation;
                }
                $praticien_id = praticienValidation($praticien_id);
                RendezVous::create([
                    "sourceable_id"=>$consultation->id,
                    "sourceable_type"=>$typeConsultation,
                    "patient_id"=>$consultation->dossier->patient->user_id,
                    "praticien_id"=>((integer) $praticien_id) !==0 ? $praticien_id :null,
                    "initiateur"=>Auth::id(),
                    "nom_medecin"=>((integer) $praticien_id) !==0 ? null :$praticien_id,
                    "motifs"=>$motifRdv,
                    "date"=>$dateRdv,
                    "statut"=>'Programmé',
                ]);
            }
        }
    }
}

if(!function_exists('praticienValidation')) {
    /**
     * Vérifie si le praticien existe
     * @param $praticien
     * @return int|void
     * @throws \App\Exceptions\PersonnnalException
     */
    function praticienValidation($praticien)
    {
        $praticienId = (integer) $praticien;

        if ($praticienId !== 0){
            $validator = Validator::make(['praticien_id'=>$praticienId],['praticien_id'=>'required|integer|exists:users,id']);

            if($validator->fails()){
                return PersonnalErrors::staticRevealError('praticien_id','le praticien spécifié n\'exite pas dans la bd');
            }else{
                return $praticienId;
            }
        }else{

            if ($praticien != ""){
                return $praticien;
            }
        }
    }
}

if(!function_exists('updatePatientInstitution')) {
    /**
     * Ajoute un patient à la liste des patients d'un établissement
     * @param $etablissement
     * @param $consultation
     */
    function updatePatientInstitution($etablissement, $consultation)
    {
        $etablissement = EtablissementExercice::find($etablissement);
        $patient = $consultation->dossier->patient;

        //Je verifie si ce patient n'est pas encore dans cette etablissement
        $nbre = EtablissementExercicePatient::where('etablissement_id', '=', $etablissement)->where('patient_id', '=', $patient->user_id)->count();
        if ($nbre == 0) {
            $etablissement->patients()->attach($patient->user_id);
        }
    }
}

if(!function_exists('updateBookingAppointment')) {
    /**
     * Met à jour un rendez vous pris lors d'une consultation
     * @param $consultation
     * @param $typeConsultation
     * @param $motifRdv
     * @param $dateRdv
     * @param $praticien_id
     */
    function updateBookingAppointment($consultation, $typeConsultation, $motifRdv, $dateRdv, $praticien_id)
    {
        $praticien_id = praticienValidation($praticien_id);
        //je récupère le rendez vous de la consultation si cela existe
        $rdv = RendezVous::where('sourceable_id',$consultation->id)
            ->where('sourceable_type','Consultation')
            ->first();

        if ($motifRdv == 'null'){
            $motifRdv = 'Rendez vous de la consultation '.$typeConsultation.' du '.$consultation->date_consultation;
        }

        if (is_null($rdv)){
//            si cela n'existe pas et que on a spécifié la date de rendez vous on crée
            if (!is_null($dateRdv) ){
                if (strlen($dateRdv) >0 && $dateRdv != 'null' &&  $dateRdv != 'Invalid date'){

                    RendezVous::create([
                        "sourceable_id"=>$consultation->id,
                        "sourceable_type"=>$typeConsultation,
                        "patient_id"=>$consultation->dossier->patient->user_id,
                        "praticien_id"=>((integer) $praticien_id) !==0 ? $praticien_id :null,
                        "initiateur"=>Auth::id(),
                        "nom_medecin"=>((integer) $praticien_id) !==0 ? null :$praticien_id,
                        "motifs"=>$motifRdv,
                        "date"=>$dateRdv,
                        "statut"=>'Programmé',
                    ]);
                }
            }
        }
        else{
            $rdv->date = $dateRdv;
            $rdv->motifs = $motifRdv;
            $rdv->praticien_id=((integer) $praticien_id) !==0 ? $praticien_id :null;
            $rdv->nom_medecin=((integer) $praticien_id) !==0 ? null :$praticien_id;
            $rdv->statut = 'Reprogrammé';

            $rdv->save();
        }
    }
}

if(!function_exists('canUpdateConsultation')) {
    /**
     * Détermine si l'utilisateur peut modifier la consultation
     * @param $consultation
     */
    function canUpdateConsultation($consultation)
    {
        $connectedUser = Auth::user();
        $role =  $connectedUser->getRoleNames()->first();
        if ($connectedUser){
            if ($connectedUser->id == $consultation->creator){
                return true;
            }elseif ( $role== 'Medecin controle' || $role == 'Admin'){
                return true;
            }else{
                PersonnalErrors::staticRevealAccesRefuse();
            }
        }
    }
}

if(!function_exists('updateConsultationContributors')) {
    /**
     * Modification des contributeurs d'une consultation
     * @param $contributeurs
     * @param $consultation
     * @param $typeOperation
     */
    function updateConsultationContributors($contributeurs, $consultation, $typeOperation)
    {
        $precedentContributeurs = [];
        //Mises à jour des contributeurs
        $contributeurs = explode(",",$contributeurs);
        if (!is_null($contributeurs)) {
            foreach ($consultation->operationables as $operation) {
                if (!in_array($operation->contributable->id, $precedentContributeurs)) {
                    array_push($precedentContributeurs, $operation->contributable->id);
                }
            }

            $difference = array_diff($contributeurs, $precedentContributeurs);
            if (!empty($difference)) {
                foreach ($difference as $contributeur) {
                    if ($contributeur !== ""){

                        $nouveauContributeur = Contributeurs::create([
                            'contributable_id' => $contributeur,
                            'contributable_type' => 'App\User',
                            'operationable_id' => $consultation->id,
                            'operationable_type' => $typeOperation

                        ]);

                    }
                }
            }

            $difference = array_diff($precedentContributeurs, $contributeurs);

            if (!empty($difference)) {
                foreach ($difference as $contributeur) {
                    $contributeur = Contributeurs::where('contributable_id', $contributeur)
                        ->where('contributable_type', 'App\User')
                        ->where('operationable_id', $consultation->id)
                        ->where('operationable_type', $typeOperation)
                        ->first();

                    $contributeur->delete();
                }
            }
        }
    }
}

if(!function_exists('archievedConsultation')) {
    /**
     * Archieve une consultation
     * @param $praticien
     * @return int|void
     * @throws \App\Exceptions\PersonnnalException
     */
    function archievedConsultation($resultat)
    {
        if (is_null($resultat->passed_at)){
            PersonnalErrors::staticRevealNonTransmis();

        }else{
            $resultat->archieved_at = Carbon::now();
            $resultat->save();

            $user = $resultat->dossier->patient->user;
            if ($user->decede == 'non') {
                informedPatientAndSouscripteurs($resultat->dossier->patient, 1);

                if ($user->isMedicasure == '1' || $user->isMedicasure == 1) {
                    sendSmsToUser($user);
                }
            }
        }
    }
}

if(!function_exists('transmitConsultation')) {
    /**
     * Transmettre une consultation
     * @param $praticien
     * @return int|void
     * @throws \App\Exceptions\PersonnnalException
     */
    function transmitConsultation($resultat)
    {
        $resultat->passed_at = Carbon::now();
        $resultat->save();

        $user = $resultat->dossier->patient->user;
        if ($user->decede == 'non') {
            if ($user->isMedicasure == '0' || $user->isMedicasure == 0) {
                \App\Traits\SmsTrait::sendSmsToUser($user);
            }
            informedPatientAndSouscripteurs($resultat->dossier->patient, 0);
        }
    }
}

if(!function_exists('reactiverConsultation')) {
    /**
     * Transmettre une consultation
     * @param $praticien
     * @return int|void
     * @throws \App\Exceptions\PersonnnalException
     */
    function reactiverConsultation($resultat)
    {
        $resultat->passed_at = null;
        $resultat->archieved_at = null;
        $resultat->save();
    }
}
