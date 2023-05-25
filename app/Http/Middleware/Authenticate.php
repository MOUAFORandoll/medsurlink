<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\TimeActivite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{


    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }

    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                $user = $this->auth->guard($guard)->user();
                $user->last_activity = Carbon::now();
                $user->save();

                $activity = TimeActivite::where('user_id', $user->id)->latest('id')->first();

                if ($activity) {
                    // Vérifier si l'utilisateur est inactif depuis plus de 30 minutes
                    $last_activity = Carbon::parse($user->last_activity);
                    $now = Carbon::now();
                    $inactive_time = $now->diffInMinutes($last_activity);

                    if ($inactive_time > 30) {
                        // Enregistrer l'heure de fin de connexion dans le champ stop
                        $activity->stop = $last_activity;
                    } else {
                        // Calculer le temps total mis sur l'application
                        $activity->stop = $now;
                        $elapsed_time = Carbon::parse($activity->start)->diffInSeconds($activity->stop);
                        $activity->temps_connecte = $elapsed_time;
                    }

                    $activity->save();
                }
                return $this->auth->shouldUse($guard);
            }
        }

        throw new AuthenticationException(
            'Unauthenticated.',
            $guards,
            $this->redirectTo($request)
        );
    }
}
