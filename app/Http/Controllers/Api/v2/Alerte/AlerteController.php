<?php

namespace App\Http\Controllers\Api\v2\Alerte;

use App\Http\Controllers\Controller;
use App\Services\Alerte\AlerteService;
use Illuminate\Http\Request;

class AlerteController extends Controller
{

    private $alerteService;

    /**
     * AlerteController constructor.
     *
     * @param \App\Services\Alerte\AlerteService $alerteService
     */
    public function __construct(AlerteService $alerteService)
    {
        $this->alerteService = $alerteService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->alerteService->fetchAlertes($request));
    }

    /**
     * @param $alerte
     *
     * @return mixed
     */
    public function show($alerte)
    {
        return $this->successResponse($this->alerteService->fetchAlerte($alerte));
    }

    /**
     * @param $user_id
     *
     * @return mixed
     */
    public function historyInfoUserAlert($user_id)
    {
        return $this->successResponse($this->alerteService->historyInfoUserAlert($user_id));
    }

    /**
     * @param $alerte
     *
     * @return mixed
     */
    public function subScribeAlerte(Request $request, $alerte)
    {
        return $this->successResponse($this->alerteService->subScribeAlerte($alerte, $request->all()));
    }

    

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->alerteService->createAlerte($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $alerte
     *
     * @return mixed
     */
    public function update(Request $request, $alerte)
    {
        return $this->successResponse($this->alerteService->updateAlerte($alerte, $request->all()));
    }

    /**
     * @param $alerte
     *
     * @return mixed
     */
    public function destroy($alerte)
    {
        return $this->successResponse($this->alerteService->deleteAlerte($alerte));
    }
}
