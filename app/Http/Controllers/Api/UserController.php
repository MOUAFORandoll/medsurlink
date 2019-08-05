<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Mail\Password\PasswordGenerated;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        foreach ( $users as $user){
            $user->roles;
        }
        return response()->json(['users'=>$users]);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $user = User::create($request->validated());
        return response()->json(['user'=>$user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $validation = $this->validatedId($id);
        if(!is_null($validation))
            return $validation;
        $user = User::find($id);
        $user->roles;
        return response()->json(['user'=>$user]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $validation = $this->validatedId($id);
        if(!is_null($validation))
            return $validation;

        $user = User::find($id);
        $user->name = $request->validated()['name'];
        $user->email = $request->validated()['email'];
        $user->password = Hash::make($request->validated()['password']);
        $user->save();

        $userRole = ((getStatusUserRole($user->getRoleNames()->first(),$user))->getOriginalContent()['auteurable_user']);
        $userRole->email  = $user->email;
        $userRole->save();

        return response()->json(['user'=>$user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $validation = $this->validatedId($id);
        if(!is_null($validation))
            return $validation;
        $user = User::find($id);
        User::destroy($id);
        return response()->json(['user'=>$user]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function validatedId($id){
        $validation = Validator::make(compact('id'),['id'=>'exists:users,id']);
        if ($validation->fails()){
            return response()->json($validation->errors(),422);
        }
        return null;
    }

    public static function generatedUser($name, $email){
        $validation = Validator::make(compact('email'),['email'=>'unique:users,email']);
        if ($validation->fails()){
            return response()->json(['email'=>$validation->errors()],422);
        }
        $password = str_random(10);
        $user = User::create([
            'name'=>$name,
            'email'=>$email,
            'password'=>Hash::make($password)
        ]);
        $mail = new PasswordGenerated($user,$password);
        Mail::to($user->email)->send($mail);
        return $user;
    }
}
