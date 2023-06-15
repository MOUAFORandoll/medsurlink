<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\FormeMedicamenteuseService;
use Illuminate\Http\Request;

class FormeMedicamenteuseController extends Controller
{

    private $forme_medicamenteuse;

    /**
     * FormeMedicamenteuseController constructor.
     *
     * @param \App\Services\FormeMedicamenteuseService $forme_medicamenteuse
     */
    public function __construct(FormeMedicamenteuseService $forme_medicamenteuse)
    {
        $this->forme_medicamenteuse = $forme_medicamenteuse;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->forme_medicamenteuse->fetchFormeMedicamenteuses($request));
    }

    /**
     * @param $forme_medicamenteuse
     *
     * @return mixed
     */
    public function show($forme_medicamenteuse)
    {
        return $this->successResponse($this->forme_medicamenteuse->fetchFormeMedicamenteuse($forme_medicamenteuse));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->forme_medicamenteuse->createFormeMedicamenteuse($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $forme_medicamenteuse
     *
     * @return mixed
     */
    public function update(Request $request, $forme_medicamenteuse)
    {
        return $this->successResponse($this->forme_medicamenteuse->updateFormeMedicamenteuse($forme_medicamenteuse, $request->all()));
    }

    /**
     * @param $forme_medicamenteuse
     *
     * @return mixed
     */
    public function destroy($forme_medicamenteuse)
    {
        return $this->successResponse($this->forme_medicamenteuse->deleteFormeMedicamenteuse($forme_medicamenteuse));
    }
}
