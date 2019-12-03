<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\PraticienStoreRequest;
use App\Http\Requests\PraticienUpdateRequest;
use App\Mail\updateSetting;
use App\Models\EtablissementExercice;
use App\Models\Praticien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PraticienController extends Controller
{
    use PersonnalErrors;
    protected $table ="praticiens";
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
     * @param PraticienStoreRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(PraticienStoreRequest $request)
    {


        //Creation de l'utilisateur dans la table user et génération du mot de passe
        $userResponse =  UserController::generatedUser($request);

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
        try{
        UserController::sendUserInformationViaMail($user,$password);
            return response()->json(['praticien'=>$praticien]);
        }catch (\Swift_TransportException $transportException){
            $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
            return response()->json(['praticien'=>$praticien, "message"=>$message]);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $praticien = Praticien::with('etablissements','user')->whereSlug($slug)->first();

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
     * @param PraticienUpdateRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(PraticienUpdateRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);

        $praticien= Praticien::with('user')->whereSlug($slug)->first();

        UserController::updatePersonalInformation($request->except('civilite','practitioner','profession_id','specialite_id','numero_ordre'),$praticien->user->slug);

        Praticien::whereSlug($slug)->update([
            'specialite_id' => $request->specialite_id,
            'numero_ordre' => $request->numero_ordre,
            'civilite' => $request->civilite
        ]);

        $praticien = Praticien::with('etablissements')->whereSlug($slug)->first();

        try{
            $mail = new updateSetting($praticien->user);

            Mail::to($praticien->user->email)->send($mail);

        }catch (\Swift_TransportException $transportException){
            $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
            return response()->json(['particien'=>$praticien, "message"=>$message]);

        }

        return response()->json(['praticien' => $praticien]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $praticien = Praticien::with('etablissements')->whereSlug($slug)->first();
        $praticien->delete();

        return response()->json(['praticien'=>$praticien]);

    }

    public function addEtablissement(Request $request){
        $request->validate([
            'etablissement_exercice_id'=>'sometimes|nullable|integer|exists:etablissement_exercices,id',
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
        defineAsAuthor("Praticien",$praticien->user_id,'attach');

        $praticien = Praticien::with('etablissements')->whereUserId($praticien->user_id)->first();

        return response()->json(['praticien'=>$praticien]);
    }

    public function removeEtablissement(Request $request){
        $request->validate([
            'etablissement_exercice_id'=>'required|integer|exists:etablissement_exercices,id',
            'praticien_id'=>'required|exists:praticiens,user_id',
        ]);

        $etablissementId = $request->get('etablissement_exercice_id');
        $praticien = Praticien::whereUserId($request->get('praticien_id'))->first();
        $etablissement = EtablissementExercice::find($etablissementId);
        $praticien->etablissements()->detach($etablissement->id);

        defineAsAuthor("Praticien",$praticien->user_id,'detach');

        $praticien = Praticien::with('etablissements')->whereUserId($praticien->user_id)->first();
        return response()->json(['praticien'=>$praticien]);
    }
}
