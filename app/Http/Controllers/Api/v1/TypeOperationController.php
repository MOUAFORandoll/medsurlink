<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AllergieRequest;
use App\Models\TypeOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeOperationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type_operations = TypeOperation::latest()->get(['id', 'libelle']);

        return response()->json(['type_operations' => $type_operations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param AllergieRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
       

    }


    /**
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function show($slug)
    {
        

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * @param AllergieRequest $request
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $slug)
    {

        
    }


    /**
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($slug)
    {
        
    }
}
