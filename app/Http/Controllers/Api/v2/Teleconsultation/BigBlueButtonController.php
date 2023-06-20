<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\BigBlueButtonService;

class BigBlueButtonController extends Controller
{

    private $bigBlueButton;

    /**
     * class BigBlueButtonController extends Controller
     *
     * @param \App\Services\BigBlueButtonService $bigBlueButton
     */
    public function __construct(BigBlueButtonService $bigBlueButton)
    {
        $this->bigBlueButton = $bigBlueButton;
    }

    /**
     * @return mixed
     */
    public function createMetting($user_id)
    {
        return $this->successResponse($this->bigBlueButton->createMetting($user_id));
    }

    /**
     * @return mixed
     */
    public function joinMetting($user_id)
    {
        return $this->successResponse($this->bigBlueButton->joinMetting($user_id));
    }



}
