<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\OptionFinancementService;
use Illuminate\Http\Request;

class OptionFinancementController extends Controller
{

    private $options_financement;

    /**
     * OptionFinancementController constructor.
     *
     * @param \App\Services\OptionFinancementService $options_financement
     */
    public function __construct(OptionFinancementService $options_financement)
    {
        $this->options_financement = $options_financement;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->options_financement->fetchOptionFinancements($request));
    }

    /**
     * @param $options_financement
     *
     * @return mixed
     */
    public function show($options_financement)
    {
        return $this->successResponse($this->options_financement->fetchOptionFinancement($options_financement));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->options_financement->createOptionFinancement($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $options_financement
     *
     * @return mixed
     */
    public function update(Request $request, $options_financement)
    {
        return $this->successResponse($this->options_financement->updateOptionFinancement($options_financement, $request->all()));
    }

    /**
     * @param $options_financement
     *
     * @return mixed
     */
    public function destroy($options_financement)
    {
        return $this->successResponse($this->options_financement->deleteOptionFinancement($options_financement));
    }
}
