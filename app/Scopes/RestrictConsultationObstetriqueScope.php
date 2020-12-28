<?php


namespace App\Scopes;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class RestrictConsultationObstetriqueScope implements Scope
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
                $consultationsObstetriqueCollection = $user->patient->dossier->consultationsObstetrique;
                $consultationsObstetrique = [];
                foreach ($consultationsObstetriqueCollection as $item){
                    array_push($consultationsObstetrique,$item->id);
                }
                if ($user->isMedicasure == 0){
                    $builder;
                }else{
                    $builder->whereIn('consultation_obstetrique_id',$consultationsObstetrique)->whereNotNull('archieved_at');
                }

            }elseif(gettype($userRoles->search('Souscripteur')) == 'integer'){
                $user = \App\User::with(['patient'])->whereId(Auth::id())->first();
                //Récupération des patiens du souscripteur
                $patients = $user->souscripteur->patients;
                $consultationsObstetrique = [];
                foreach ($patients as $patient){
                        //Récupération des consultations obstétrique des patients
                    $consultationsObstetriqueCollection = $patient->dossier->consultationsObstetrique;
                    foreach ($consultationsObstetriqueCollection as $item){
                        array_push($consultationsObstetrique,$item->id);
                    }
                }

                $builder->whereIn('consultation_obstetrique_id',$consultationsObstetrique)->whereNotNull('archieved_at');
            }
            else{
                return $builder;
            }
        }else{
            throw new UnauthorizedException("Veuillez vous authentifier",401);
        }

    }
}
