<?php


namespace App\Scopes;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class RestrictResultatScope implements Scope
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
                $builder->where('dossier_medical_id','=',$dossier->id)->whereNotNull('archived_at');
            }elseif(gettype($userRoles->search('Souscripteur')) == 'integer'){                return response()->json(Auth::user(),419);
//                return response()->json(Auth::id(),419);
                $user = \App\User::with(['patient'])->whereId(Auth::id())->first();
                $patients = $user->souscripteur->patients;
                $dossiers = [];
                foreach ($patients as $patient){
                    if (!is_null($patient->dossier)){
                        array_push($dossiers,$patient->dossier->id);
                    }
                }
                $builder->whereIn('dossier_medical_id',$dossiers)->whereNotNull('archived_at');
            }elseif(gettype($userRoles->search('Medecin controle')) == 'integer'){
                $builder->whereNotNull('passed_at');
                $builder;
            }
            else{
                return $builder;
            }
        }else{
            throw new UnauthorizedException("Veuillez vous authentifier",401);
        }

    }
}
