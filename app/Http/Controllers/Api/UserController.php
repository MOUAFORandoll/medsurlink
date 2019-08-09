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
    public function store(Request $request)
    {
        $user = self::generatedUser($request);
        return response()->json(['user'=>$user->getOriginalContent()]);
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

    public static function generatedUser($request){

       $validation = Validator::make($request->all(),[
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['sometimes','nullable', 'string', 'max:255'],
            'nationalite' => ['required', 'string', 'max:255'],
            'quartier' => ['sometimes','nullable', 'string', 'max:255'],
            'code_postal' => ['sometimes','nullable', 'integer'],
            'ville' => ['required','string', 'max:255'],
            'pays' => ['required','string', 'max:255'],
            'telephone' => ['required','string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
//            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validation->fails())
           return response()->json(['error'=>$validation->errors()],419);

        $password = str_random(10);

        $user = User::create([
            'nom'=>$request->nom,
            'prenom'=>$request->prenom,
            'email'=>$request->email,
            'nationalite'=>$request->nationalite,
            'quartier'=>$request->quartier,
            'code_postal'=>$request->code_postal,
            'ville'=>$request->ville,
            'pays'=>$request->pays,
            'telephone'=>$request->telephone,
            'password'=>Hash::make($password)
        ]);

        return response()->json(['user'=>$user,'password'=>$password]);
    }

    public static function sendUserInformationViaMail(User $user,$password){
        $mail = new PasswordGenerated($user,$password);
        Mail::to($user->email)->send($mail);
    }
}
