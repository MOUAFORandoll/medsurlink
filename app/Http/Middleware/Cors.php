<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE, PATCH");
        header("Access-Control-Allow-Headers:  Origin, Content-Type, X-Auth-Token, Authorization, X-Requested-With, x-xsrf-token, x-csrf-token");
        //ALLOW OPTIONS METHOD
        $headers = [
            'Access-Control-Allow-Origin:' =>'Accept, Allow',
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE, PATCH',
            'Access-Control-Allow-Headers' => 'Origin, Content-Type, X-Auth-Token, Authorization, X-Requested-With, x-xsrf-token, x-csrf-token',
        ];
        if ($request->getMethod() == "OPTIONS"){
            //The client-side application can set only headers allowed in Access-Control-Allow-Headers
            return response()->json('OK',200,$headers);
        }
        $response = $next($request);
        foreach ($headers as $key => $value) {
            $response->header($key, $value);
        }
        return $response;
    }
}
