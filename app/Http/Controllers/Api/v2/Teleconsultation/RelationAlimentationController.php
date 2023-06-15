<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\RelationAlimentationService;
use Illuminate\Http\Request;

class RelationAlimentationController extends Controller
{

    private $relation_alimentaire;

    /**
     * RelationAlimentationController constructor.
     *
     * @param \App\Services\RelationAlimentationService $relation_alimentaire
     */
    public function __construct(RelationAlimentationService $relation_alimentaire)
    {
        $this->relation_alimentaire = $relation_alimentaire;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->relation_alimentaire->fetchRelationAlimentations($request));
    }

    /**
     * @param $relation_alimentaire
     *
     * @return mixed
     */
    public function show($relation_alimentaire)
    {
        return $this->successResponse($this->relation_alimentaire->fetchRelationAlimentation($relation_alimentaire));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->relation_alimentaire->createRelationAlimentation($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $relation_alimentaire
     *
     * @return mixed
     */
    public function update(Request $request, $relation_alimentaire)
    {
        return $this->successResponse($this->relation_alimentaire->updateRelationAlimentation($relation_alimentaire, $request->all()));
    }

    /**
     * @param $relation_alimentaire
     *
     * @return mixed
     */
    public function destroy($relation_alimentaire)
    {
        return $this->successResponse($this->relation_alimentaire->deleteRelationAlimentation($relation_alimentaire));
    }
}
