<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\PatientService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private $user;

    /**
     * UserController constructor.
     *
     * @param \App\Services\PatientService $user
     */
    public function __construct(PatientService $user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function medecin()
    {
        return $this->successResponse($this->user->medecin());
    }

   
}
