<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PraticienStoreRequest;
use App\Http\Requests\PraticienUpdateRequest;
use App\Models\EtablissementExercice;
use App\Models\Praticien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PraticienController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $praticiens = Praticien::with(['etablissements','specialite','user'])->get();
        return response()->json(['praticiens'=>$praticiens]);
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
    public function store(PraticienStoreRequest $request)
    {

        //Creation de l'utilisateur dans la table user et génération du mot de passe
        $userResponse =  UserController::generatedUser($request);
        if ($userResponse->status() == 419)
            return $userResponse;

        $user = $userResponse->getOriginalContent()['user'];
        $password = $userResponse->getOriginalContent()['password'];
        //Attribution du rôle patient
        $user->assignRole('Praticien');

        //Sauvegarde des informations specifique
        $praticien = Praticien::create($request->validated() + ['user_id' => $user->id]);
        $praticien->etablissements()->attach($request->get('etablissement_id'));
        $praticien->save();

        defineAsAuthor("Praticien",$praticien->user_id,'create');

        //Envoi des informations patient par mail
        UserController::sendUserInformationViaMail($user,$password);
        return response()->json(['praticien'=>$praticien]);

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
        $praticien = Praticien::with('etablissements','user')->whereUserId($id)->first();
        return response()->json(['praticien'=>$praticien]);

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
    public function update(PraticienUpdateRequest $request, $id)
    {
         $validation = $this->validatedId($id);
        if(!is_null($validation))
            return $validation;
        Praticien::whereUserId($id)->update($request->validated());
        $praticien = Praticien::with('etablissements')->whereUserId($id)->first();
//
//        //ajustement de l'email du user
//        $user = $praticien->user;
//        $user->email = $praticien->email;
//        $user->save();

        return response()->json(['praticien'=>$praticien]);

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
        $praticien = Praticien::with('etablissements')->whereUserId($id)->first();
        $praticien->delete();
        return response()->json(['praticien'=>$praticien]);

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function validatedId($id){
        $validation = Validator::make(compact('id'),['id'=>'exists:praticiens,user_id']);
        if ($validation->fails()){
            return response()->json($validation->errors(),422);
        }
        return null;
    }

    public function addEtablissement(Request $request){
        $request->validate([
            'etablissement_exercice_id'=>'sometimes|nullable|integer',
            'praticien_id'=>'required|exists:praticiens,user_id',
            'name'=>'sometimes|nullable|string|min:5',
        ]);

        $etablissementId = $request->get('etablissement_exercice_id');
        $praticien = Praticien::whereUserId($request->get('praticien_id'))->first();

        if ($request->get('etablissement_exercice_id') == 0){
           $etablissement = EtablissementExercice::create([
                'name'=>$request->get('name')
            ]);
        }else{
            $validation = Validator::make(compact('etablissementId'),['etablissementId'=>'exists:etablissement_exercices,id']);
            if ($validation->fails()){
                return response()->json(['id'=>$validation->errors()],422);
            }
            $etablissement = EtablissementExercice::find($etablissementId);
        }

        $praticien->etablissements()->attach($etablissement->id);
        $praticien = Praticien::with('etablissements')->whereUserId($praticien->user_id)->first();
        return response()->json(['praticien'=>$praticien]);
    }

    public function removeEtablissement(Request $request){
        $request->validate([
            'etablissement_exercice_id'=>'required||integer',
            'praticien_id'=>'required|exists:praticiens,user_id',
        ]);

        $etablissementId = $request->get('etablissement_exercice_id');
        $praticien = Praticien::whereUserId($request->get('praticien_id'))->first();
        $etablissement = EtablissementExercice::find($etablissementId);
        $praticien->etablissements()->detach($etablissement->id);

        $praticien = Praticien::with('etablissements')->whereUserId($praticien->user_id)->first();
        return response()->json(['praticien'=>$praticien]);
    }
}
