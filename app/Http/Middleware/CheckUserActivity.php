<?php

namespace App\Http\Middleware;

use App\Models\TimeActivite;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserActivity extends Authenticate
{

    /**
     * The maximum idle time allowed in seconds.
     */
    protected $maxIdleTime = 1800; // 30 minutes

    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $response = $next($request);

        if (Auth::check()) {
            $user = Auth::user();

            // Vérifie si l'utilisateur est inactif depuis $maxIdleTime secondes
            if ($this->isUserInactive($user)) {
                // Récupère l'entrée la plus récente pour l'utilisateur connecté et met à jour les champs stop et temps_connecte
                $activity = TimeActivite::where('user_id', $user->id)->orderBy('start', 'desc')->first();
                $activity->stop = now();
                $activity->temps_connecte = $activity->start->diffInSeconds($activity->stop);
                $activity->save();
            }
        }

        return $response;
    }

    /**
     * Determine if the user is inactive.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return bool
     */
    protected function isUserInactive($user)
    {
        return time() - session('last_activity') > $this->maxIdleTime;
    }
}
