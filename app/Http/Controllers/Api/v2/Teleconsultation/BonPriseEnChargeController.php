<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Mail\Teleconsultations\ShareBonPriseEnCharge;
use App\Models\DossierMedical;
use App\Services\BonpriseEnChargeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BonPriseEnChargeController extends Controller
{

    private $bonPriseEnChargeService;

    /**
     *
     * @param \App\Services\BonpriseEnChargeService $bonPriseEnChargeService
     */
    public function __construct(BonpriseEnChargeService $bonPriseEnChargeService)
    {
        $this->bonPriseEnChargeService = $bonPriseEnChargeService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        $patient_search = $request->search;
        $patients = seachPatient($patient_search);
        $request->request->add(['patients' => $patients]);
        return $this->successResponse($this->bonPriseEnChargeService->fetchBonPriseEnCharges($request));
    }

    /**
     * @param $bon_prise_en_charge
     *
     * @return mixed
     */
    public function show($bon_prise_en_charge)
    {
        return $this->successResponse($this->bonPriseEnChargeService->fetchBonPriseEnCharge($bon_prise_en_charge));
    }


    /**
     * @param $bon_prise_en_charge
     *
     * @return mixed
     */
    public function emails(Request $request, $bon_prise_en_charge)
    {
        $emails = [];
        foreach(explode(",", $request->email) as $email) {
            $emails[] = trim($email);
        }
        $message = $request->message;
        $subject = "Bon de prise en charge";
        $route = route('bon_prise_en_charges.print', $bon_prise_en_charge);
        Mail::to($emails)->send(new ShareBonPriseEnCharge($subject, $message, $route));
        return $this->successResponse($subject);
    }

    /**
     * recuperation de tout les bons de prises en charge d'un patient
     * @param $patient_id
     *
     * @return mixed
     */
    public function getBonPrisesEnCharges(Request $request, $patient_id)
    {
        $dossier = DossierMedical::whereSlug($patient_id)->latest()->first();
        if(!is_null($dossier)){
            $patient_id = $dossier->patient_id;
        }
        return $this->successResponse($this->bonPriseEnChargeService->getBonPrisesEnCharges($request, $patient_id));
    }


    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $request->request->add(['creator' => \Auth::guard('api')->user()->id]);
        return $this->successResponse($this->bonPriseEnChargeService->createBonPriseEnCharge($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $bon_prise_en_charge
     *
     * @return mixed
     */
    public function update(Request $request, $bon_prise_en_charge)
    {
        $request->request->add(['creator' => \Auth::guard('api')->user()->id]);
        return $this->successResponse($this->bonPriseEnChargeService->updateBonPriseEnCharge($bon_prise_en_charge, $request->all()));
    }

    /**
     * @param $bon_prise_en_charge
     *
     * @return mixed
     */
    public function destroy($bon_prise_en_charge)
    {
        return $this->successResponse($this->bonPriseEnChargeService->deleteBonPriseEnCharge($bon_prise_en_charge));
    }

    /**
     * @param $patient_id
     *
     * @return mixed
     */
    public function resultats($patient_id)
    {
        return $this->successResponse($this->bonPriseEnChargeService->fetchResultats($patient_id));
    }
}
