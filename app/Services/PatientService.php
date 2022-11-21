<?php

namespace App\Services;

use App\Models\Patient;
use App\Traits\RequestService;
use App\User;
use Illuminate\Http\Request;

class PatientService
{
    use RequestService;

    /**
     * @return array
     */
    public function fetchPatients(Request $request)
    {
        $value = $request->search;

        $patients = Patient::with(['dossier:patient_id,id,numero_dossier', 'user:id,nom,prenom,email,slug','affiliations.package:id,description_fr'])
            ->whereHas('user', function($q) use ($value) {
                $q->where('nom', 'like', '%' .$value.'%')
                ->orwhere('prenom', 'like', '%' .$value.'%')
                ->orwhere('email', 'like', '%' .$value.'%');
            })
            ->orwhereHas('dossier', function($q) use ($value) {
                $q->where('numero_dossier', 'like', '%' .$value.'%');
            })
            ->orwhere('age', 'like', '%' .$value.'%')->get();

        return $patients;
    }

    /**
     * @param $patient
     *
     * @return string
     */
    public function fetchPatient(Request $request, $patient)
    {
        $associations = $request->associations;

        return $this->getPatient($patient, $associations);
    }

    public function getPatient(int $patient, string $associations){
        $patient = Patient::where('user_id', $patient);

        if(str_contains($associations, "dossier")){
            $patient = $patient->with('dossier:patient_id,id,numero_dossier');
        }
        if(str_contains($associations, "user")){
            $patient = $patient->with('user:id,nom,prenom,email,slug');
        }
        if(str_contains($associations, "affiliations")){
            $patient = $patient->with('affiliations.package:id,description_fr');
        }
        $patient = $patient->first();
        //$patient = $patient->firstOrFail();
        return $patient;
    }

    public function medecin()
    {
        $user = \Auth::guard('api')->user();
        $user->token = $user->createToken(config('services.teleconsultations.secret'))->accessToken;
        if($user->medecinControle != null){
            $user->medecin = $user->medecinControle->makeHidden(['deleted_at', 'created_at', 'updated_at']);
        }
        $user->roles = $user->roles->makeHidden(['guard_name', 'created_at', 'updated_at', 'pivot']);
        $user->makeHidden(['quartier', 'created_at', 'updated_at', 'deleted_at', 'adresse', 'isNotice', 'smsEnvoye', 'email_verified_at']);
        return $user;
    }
}
