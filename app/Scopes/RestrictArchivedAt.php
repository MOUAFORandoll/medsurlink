<?php


namespace App\Scopes;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class RestrictArchivedAt implements Scope
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
        $user = Auth::user();
        $userRoles = $user->getRoleNames();
        if(gettype($userRoles->search('Souscripteur')) == 'integer' || gettype($userRoles->search('Patient')) == 'integer'){
            if ($user->isMedicasure == '0'){
                $builder->whereNotNull('passed_at');
            }
            else{
                $builder->whereNotNull('archived_at');
            }
        }

    }
}
