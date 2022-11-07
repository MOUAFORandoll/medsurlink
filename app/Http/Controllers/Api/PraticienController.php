<?php

namespace App\Http\Controllers\Api;

use App\Models\Comptable;
use App\Models\Praticien;
<<<<<<< HEAD
use App\Mail\updateSetting;
=======
>>>>>>> 42f28003 (début de la mise en place du timeactivies function)
use App\Models\TimeActivite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Models\EtablissementExercice;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\PraticienStoreRequest;
use App\Http\Requests\PraticienUpdateRequest;
use App\Models\EtablissementExercicePraticien;
use App\Http\Controllers\Traits\PersonnalErrors;

class PraticienController extends Controller
{
    use PersonnalErrors;
    protected $table ="praticiens";
    /**
     * Display a listing of the resource.
     * Display a listing of the resource.
     * @OA\Get(
     *      path="/praticien",
     *      operationId="getPraticienList",
     *      tags={"Praticien"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Get list of Praticiens",
     *      description="Return list of Praticiens",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
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
     * @OA\Post(
     *      path="/praticien/{praticien}",
     *      operationId="storePraticienList",
     *      tags={"Praticien"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Store Praticiens",
     *      description="Return a Praticiens",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
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
        $etablissements = $request->get('etablissement_id');
        $etablissements = explode(",",$etablissements);

        $praticien = Praticien::create($request->validated() + ['user_id' => $user->id]);
        //Ajout des établissements
        $estDeMedicasure = $request->get('isMedicasure') == "1";
        if ($estDeMedicasure || empty(array_diff([0],$etablissements))){
            $etablissements = EtablissementExercice::all();
            foreach ($etablissements as $etablissement){
                $praticien->etablissements()->attach($etablissement->id);
                defineAsAuthor("Praticien",$praticien->user_id,'Add etablissement '.$etablissement->id);
//                $isComptable = $request->get('isComptable','0');
//                if($isComptable == '1' || $isComptable == 1){
//                    Comptable::create([
//                        'user_id'=>$user->id,
//                        'etablissement_id'=>$etablissement->id,
//                        'creator'=>Auth::id()
//                    ]);
//                }
            }
        }else{
            foreach (array_diff($etablissements,[0]) as $etablissement){
                $praticien->etablissements()->attach($etablissement);
                $isComptable = $request->get('isComptable','0');
//                if($isComptable == '1' || $isComptable == 1){
//                    Comptable::create([
//                        'user_id'=>$user->id,
//                        'etablissement_id'=>$etablissement,
//                        'creator'=>Auth::id()
//                    ]);
//                }
                defineAsAuthor("Praticien",$praticien->user_id,'Add etablissement '.$etablissement);
            }
        }

        if($request->hasFile('signature')) {
            if ($request->file('signature')->isValid()) {
                $path = $request->signature->store('public/Praticien/' . $praticien->slug . '/Signature');
                $file = str_replace('public/', '', $path);

                $praticien->signature = $file;

                $praticien->save();
            }
        }

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
     * @OA\Get(
     *      path="/praticien/{praticien}", 
     *      operationId="ShowPraticienList",
     *      tags={"Praticien"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Show a Praticiens",
     *      description="Return a Praticiens details",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $praticien = Praticien::with('etablissements','specialite','user')->whereSlug($slug)->first();

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
     * Update the specified resource in storage..
     * @OA\Put(
     *      path="/praticien/{praticien}",
     *      operationId="UpdatePraticienList",
     *      tags={"Praticien"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Update a Praticiens",
     *      description="Update Praticiens",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     * @param PraticienUpdateRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(PraticienUpdateRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);

        $praticien= Praticien::with('user')->whereSlug($slug)->first();

        UserController::updatePersonalInformation($request->except('civilite','practitioner','profession_id','specialite_id','numero_ordre','signature'),$praticien->user->slug);

        Praticien::whereSlug($slug)->update([
            'specialite_id' => $request->specialite_id,
            'numero_ordre' => $request->numero_ordre,
            'civilite' => $request->civilite
        ]);

        $praticien = Praticien::with('etablissements','specialite','user')->whereSlug($slug)->first();

        $signature = $praticien->signature;

        if($request->hasFile('signature')){
            if ($request->file('signature')->isValid()) {
                $path = $request->signature->store('public/Praticien/' . $praticien->slug . '/Signature');
                $file = str_replace('public/', '', $path);

                $praticien->signature = $file;

                $praticien->save();
            }
        }

        if (!is_null($signature))
            File::delete(public_path().'/storage/'.$signature);

        try{
            $mail = new updateSetting($praticien->user);

            Mail::to($praticien->user->email)->send($mail);

        }catch (\Swift_TransportException $transportException){
            Log::error($transportException->getMessage());
            $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
            return response()->json(['particien'=>$praticien, "message"=>$message]);

        }

        return response()->json(['praticien' => $praticien]);
    }

    /**
     * Remove the specified resource from storage.
     * @OA\Delete(
     *      path="/praticien/{praticien}",
     *      operationId="deletePraticienList",
     *      tags={"Praticien"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Delete Praticiens",
     *      description="Return a list Praticiens",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $praticien = Praticien::with('etablissements','specialite','user')->whereSlug($slug)->first();
        $praticien->delete();

        return response()->json(['praticien'=>$praticien]);

    }

    public function addEtablissement(Request $request){
        $validation = Validator::make($request->all(),[
            'etablissement_exercice_id.*'=>'sometimes|nullable|integer',
            'praticien_id'=>'required|exists:praticiens,slug',
        ]);

        if ($validation->fails()){
            return response()->json(['id'=>$validation->errors()],422);
        }

        $etablissements = $request->get('etablissement_exercice_id');
        $praticien = Praticien::whereSlug($request->get('praticien_id'))->first();
        if (!in_array(0,$etablissements)) {
            foreach ($etablissements as $etablissementId) {
                $etablissement = EtablissementExercice::find($etablissementId);
                //Je verifie si ce praticien n'est pas encore dans cette etablissement
                $nbre = EtablissementExercicePraticien::where('etablissement_id', '=', $etablissementId)->where('praticien_id', '=', $praticien->user_id)->count();
                if ($nbre == 0) {
                    $praticien->etablissements()->attach($etablissement->id);
                    defineAsAuthor("Praticien", $praticien->user_id, 'attach');
                }
            }
        }else{
            foreach ($praticien->etablissements as $etablissement){
                $praticien->etablissements()->detach($etablissement->id);
            }

            $etablissements = EtablissementExercice::all();
            foreach ($etablissements as $etablissement){
                $praticien->etablissements()->attach($etablissement->id);
                defineAsAuthor("Praticien",$praticien->user_id,'Add etablissement '.$etablissement->id);
            }
        }
        $praticien = Praticien::with('etablissements','specialite','user')->whereUserId($praticien->user_id)->first();

        return response()->json(['praticien'=>$praticien]);
    }

    public function removeEtablissement(Request $request){
        $validation = Validator::make($request->all(),[
            'etablissement_id.*'=>'required|integer|exists:etablissement_exercices,id',
            'praticien_id'=>'required|exists:praticiens,user_id',
        ]);

        if ($validation->fails()){
            return response()->json(['id'=>$validation->errors()],422);
        }

        $etablissements = $request->get('etablissement_id');
        $praticien = Praticien::whereUserId($request->get('praticien_id'))->first();
        foreach ($etablissements as $etablissementId){
            $etablissement = EtablissementExercice::find($etablissementId);
            $praticien->etablissements()->detach($etablissement->id);
            defineAsAuthor("Praticien",$praticien->user_id,'detach etablissement '.$etablissement->name);
        }


        $praticien = Praticien::with('etablissements','specialite','user')->whereUserId($praticien->user_id)->first();
        return response()->json(['praticien'=>$praticien]);
    }
<<<<<<< HEAD

    public function timeActivities() {
        $praticien = Praticien::with('time','user')->withCount('time')->get();
        return response()->json(['praticien' => $praticien]);
=======
    public function timeActivities() {
        $praticien = TimeActivite::with(['etablissements','specialite','user'])->get();
        return response()->success($praticien, 'Package of subscription successfully changed !',  200);
>>>>>>> 42f28003 (début de la mise en place du timeactivies function)
    }
}
