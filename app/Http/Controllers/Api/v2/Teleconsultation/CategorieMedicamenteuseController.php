<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\CategorieMedicamenteuseService;
use Illuminate\Http\Request;

class CategorieMedicamenteuseController extends Controller
{

    private $categorie_medicamenteuse;

    /**
     * CategorieMedicamenteuseController constructor.
     *
     * @param \App\Services\CategorieMedicamenteuseService $categorie_medicamenteuse
     */
    public function __construct(CategorieMedicamenteuseService $categorie_medicamenteuse)
    {
        $this->categorie_medicamenteuse = $categorie_medicamenteuse;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->categorie_medicamenteuse->fetchCategorieMedicamenteuses($request));
    }

    /**
     * @param $categorie_medicamenteuse
     *
     * @return mixed
     */
    public function show($categorie_medicamenteuse)
    {
        return $this->successResponse($this->categorie_medicamenteuse->fetchCategorieMedicamenteuse($categorie_medicamenteuse));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->categorie_medicamenteuse->createCategorieMedicamenteuse($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $categorie_medicamenteuse
     *
     * @return mixed
     */
    public function update(Request $request, $categorie_medicamenteuse)
    {
        return $this->successResponse($this->categorie_medicamenteuse->updateCategorieMedicamenteuse($categorie_medicamenteuse, $request->all()));
    }

    /**
     * @param $categorie_medicamenteuse
     *
     * @return mixed
     */
    public function destroy($categorie_medicamenteuse)
    {
        return $this->successResponse($this->categorie_medicamenteuse->deleteCategorieMedicamenteuse($categorie_medicamenteuse));
    }
}
