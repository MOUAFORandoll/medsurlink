<?php


namespace App\Scopes;


use App\Models\PatientSouscripteur;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class RestrictDossierScope implements Scope
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
        // TODO: Implement apply() method.

        if (Auth::check()){
            $user = Auth::user();
            $userRoles = $user->getRoleNames();
            if(gettype($userRoles->search('Patient')) == 'integer'){

                $user = \App\User::with(['patient'])->whereId(Auth::id())->first();

                $dossier = $user->patient->dossier;
                if ($user->isMedicasure == 0){
                    $builder;
                }else {
                    $builder->where('dossier_medical_id', '=', $dossier->id)->whereNotNull('archieved_at');
                }
            }elseif(gettype($userRoles->search('Souscripteur')) == 'integer'){
                    $user = \App\User::with(['patient'])->whereId(Auth::id())->first();
                    $patients = $user->souscripteur->patients;
                    $dossiers = [];
                    foreach ($patients as $patient){
                        if (!is_null($patient->dossier)){
                            // dd($patients);
                            array_push($dossiers,$patient->dossier->id);
                        }
                    }
                $patientSouscripteurs = PatientSouscripteur::where('financable_id',Auth::id())->get();

                // foreach ($patientSouscripteurs as  $patient){
                //     if (in_array($patient->patients->dossier->id,$dossiers)){
                //         //dd($patient->patients->dossier->id);
                //         array_push($patientsId,$patient->patients->dossier->id);
                        
                //     }
                // }
                if ($user->isMedicasure == 0){
                    $builder;
                }else {
                    $builder->whereIn('dossier_medical_id', $dossiers)->whereNotNull('archieved_at');
                }
            }elseif(gettype($userRoles->search('Medecin controle')) == 'integer'){
                $builder;
            }
            else{
                return $builder;
            }
        }else{
            //throw new UnauthorizedException("Veuillez vous authentifier",401);
        }

    }
}
