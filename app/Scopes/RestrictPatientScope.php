<?php


namespace App\Scopes;

use App\Http\Controllers\Traits\Autorisation;
use App\Models\PatientSouscripteur;
use Firebase\JWT\JWT;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\UnauthorizedException;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Http\Controllers\AuthorizationController;
use Laravel\Passport\Token;

class RestrictPatientScope implements Scope
{
    use Autorisation;
    use HasApiTokens;
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (Auth::check()){

            $element = DB::table('oauth_access_tokens')->whereId($this->getBearerToken())->first();
            $user = Auth::user();

            $userRoles = $user->getRoleNames();
            if(gettype($userRoles->search('Patient')) == 'integer'){

                $user = \App\User::with(['patient'])->whereId(Auth::id())->first();
                $patient = $user->patient;
                $builder->where('patient_id',$patient->user_id);

            }elseif(gettype($userRoles->search('Souscripteur')) == 'integer'){
                $user = \App\User::with(['patient'])->whereId(Auth::id())->first();
                //Récupération des patiens du souscripteur
                $patients = $user->souscripteur->patients;
                $patientsId = [];

                foreach ($patients as $patient){
                    array_push($patientsId,$patient->user_id);
                }

                $patientSouscripteurs = PatientSouscripteur::where('financable_id',Auth::id())->get();

                foreach ($patientSouscripteurs as  $patient){
                    if (in_array($patient->patient_id,$patientsId)){
                        array_push($patientsId,$patient->patient_id);
                    }
                }

                $builder->whereIn('patient_id',$patientsId);
            }
            else{

            }
        }
    }
}
