<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\PatientService;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    private $patient;

    /**
     * PatientController constructor.
     *
     * @param \App\Services\PatientService $patient
     */
    public function __construct(PatientService $patient)
    {
        $this->patient = $patient;
    }


    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        $patients = $this->patient->fetchPatients($request);
        return $this->successResponse($patients);
    }    

    public function show($patient_id){
        
        $patient = $this->patient->fetchPatient($patient_id);
        return $this->successResponse($patient);
    }
}
