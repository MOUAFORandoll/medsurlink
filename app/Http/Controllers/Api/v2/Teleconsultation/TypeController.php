<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\TypeService;
use Illuminate\Http\Request;

class TypeController extends Controller
{

    private $type;

    /**
     * TypeController constructor.
     *
     * @param \App\Services\TypeService $type
     */
    public function __construct(TypeService $type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->type->fetchTypes($request));
    }

    /**
     * @param $type
     *
     * @return mixed
     */
    public function show($type)
    {
        return $this->successResponse($this->type->fetchType($type));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->type->createType($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $type
     *
     * @return mixed
     */
    public function update(Request $request, $type)
    {
        return $this->successResponse($this->type->updateType($type, $request->all()));
    }

    /**
     * @param $type
     *
     * @return mixed
     */
    public function destroy($type)
    {
        return $this->successResponse($this->type->deleteType($type));
    }
}
