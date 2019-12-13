<?php


namespace App\Scopes;


use App\Models\EtablissementExercicePatient;
use App\Models\EtablissementExercicePraticien;
use App\Models\Praticien;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class RestrictEtablissementScope implements Scope
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
            $userRoles = $user->getRoleNames();
            if(gettype($userRoles->search('Patient')) == 'integer'){
                $user = \App\User::with(['patient'])->whereId(Auth::id())->first();
                //Recuperation des etablissements du patient
                if (!is_null($user->patient)){
                    $etablissements = EtablissementExercicePatient::where('patient_id','=',Auth::id())->get();
                    $etablissementsId = [];

                    foreach ($etablissements as $etablissement){
                        if (!is_null($etablissement)){
                            array_push($etablissementsId, $etablissement->etablissement_id);
                        }
                    }
                    $builder->whereIn('id',$etablissementsId);
                }
            }
            elseif(gettype($userRoles->search('Souscripteur')) == 'integer'){
                $user = \App\User::whereId(Auth::id())->first();
                $patients = $user->souscripteur->patients;
                $patientsId = [];
                foreach ($patients as $patient){
                    if (!is_null($patientsId)){
                        array_push($patientsId,$patient->user_id);
                    }
                }
                $etablissements = EtablissementExercicePatient::whereIn('patient_id',$patientsId)->get();
                $etablissementsId = [];
                foreach ($etablissements as $etablissement){
                    if (!is_null($etablissement)){
                        array_push($etablissementsId, $etablissement->etablissement_id);
                    }
                }
                $builder->whereIn('id',$etablissementsId);
            }
            elseif(gettype($userRoles->search('Praticien')) == 'integer'){
                $user = \App\User::with(['praticien'])->whereId(Auth::id())->first();
                //Recuperation des etablissements du praticien
                if (!is_null($user->praticien)){
                    $etablissements = EtablissementExercicePraticien::where('praticien_id','=',Auth::id())->get();
                    $etablissementsId = [];
                    foreach ($etablissements as $etablissement){
                        if (!is_null($etablissement))
                        {
                            array_push($etablissementsId, $etablissement->etablissement_id);
                        }
                    }
                    $builder->whereIn('id',$etablissementsId);
                }
            }elseif(gettype($userRoles->search('Medecin controle')) == 'integer'){
                $builder;
            }
            elseif(gettype($userRoles->search('Admin')) == 'integer'){
                $builder;
            }
        }else{
            throw new UnauthorizedException("Veuillez vous authentifier",401);
        }


    }
}
