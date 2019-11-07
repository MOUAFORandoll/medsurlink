<?php


namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class RestrictPatientScope implements Scope
{

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
            $user = Auth::user();
            $userRoles = $user->getRoleNames();;
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
                $builder->whereIn('patient_id',$patientsId);
            }
            else{

            }
        }else{
            throw new UnauthorizedException("Veuillez vous authentifier",401);
        }
    }
}
