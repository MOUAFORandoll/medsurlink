<?php

namespace App\Http\Controllers\Api\v2\Globale;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;


class Usercontroller extends Controller
{
    private $userService;

    /**
     * class UserController extends Controller
     *
     * @param \App\Services\UserService $user
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->userService->index($request));
    }

    /**
     * @param $user
     *
     * @return mixed
     */
    public function show($user)
    {
        return $this->successResponse($this->userService->show($user));
    }


    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validations());
        return $this->successResponse($this->userService->store($request));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $user
     *
     * @return mixed
     */
    public function update(Request $request, $user)
    {
        $this->validate($request, $this->validations(true));
        return $this->successResponse($this->userService->update($request, $user));
    }

    /**
     * fonction de validation des formulaires
     */
    public function validations($is_update = null){
        if($is_update){
            $rules = [
                'nom' => 'required',
                'prenom' => 'required',
                'email' => 'required|email:rfc,dns|unique:users',
                'sexe' => 'required',
                'ville' => 'required',
                'password' => 'required|confirmed'
            ];
        }else{
            $rules = [
                'nom' => 'required',
                'prenom' => 'required',
                'email' => 'required|email:rfc,dns|unique:users',
                'sexe' => 'required',
                'ville' => 'required',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
            ];
        }
        return $rules;
    }
}