<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\MedecinControleStoreRequest;
use App\Http\Requests\MedecinControleUpdateRequest;
use App\Mail\updateSetting;
use App\Models\EtablissementExercice;
use App\Models\EtablissementExerciceMedecin;
use App\Models\MedecinControle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MedecinControleController extends Controller
{
    use PersonnalErrors;
    protected $table = "medecin_controles";

    /**
     * Display a listing of the resource.
     * @OA\Get(
     *      path="/medecin-controle",
     *      operationId="getMedecinReferentList",
     *      tags={"MedecinReferent"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Get list of Medecin Referent",
     *      description="Return list of Medecin Referent",
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
        $medecins = MedecinControle::with(['etablissements','specialite','user'])->latest()->get();
        return response()->json(['medecins'=>$medecins]);
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
     *      path="/medecin-controle/{medecin-controle}",
     *      operationId="StoreMedecinReferentList",
     *      tags={"MedecinReferent"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Store Medecin Referent",
     *      description="Returns a Medecin Referent",
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
     * @param MedecinControleStoreRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(MedecinControleStoreRequest $request)
    {
        if ($request->has('error'))
        {
            return  response()->json(['error'=>$request->all()['error']],419);
        }

        $etablissements = $request->get('etablissements');
        $etablissements = explode(",",$etablissements);

        //Création des informations utilisateurs
        $userResponse =  UserController::generatedUser($request);

        $user = $userResponse->getOriginalContent()['user'];
        $password = $userResponse->getOriginalContent()['password'];
        $user->assignRole('Medecin controle');

        $medecin = MedecinControle::create($request->validated() + ['user_id' => $user->id]);

        if($request->hasFile('signature')) {
            if ($request->file('signature')->isValid()) {
                $path = $request->signature->store('public/Medecin/' . $medecin->slug . '/Signature');
                $file = str_replace('public/', '', $path);

                $medecin->signature = $file;

                $medecin->save();
            }
        }
        defineAsAuthor("MedecinControle",$medecin->user_id,'create');

        $estDeMedicasure = $request->get('isMedicasure') == "1";

        //Ajout des établissements
        if ($estDeMedicasure){
            $etablissements = EtablissementExercice::all();
            foreach ($etablissements as $etablissement){
                $medecin->etablissements()->attach($etablissement->id);
                defineAsAuthor("MedecinControle",$medecin->user_id,'Add etablissement '.$etablissement->id);
            }
        }else{
                foreach (array_diff($etablissements,[0]) as $etablissement){
                    $medecin->etablissements()->attach($etablissement);
                    defineAsAuthor("MedecinControle",$medecin->user_id,'Add etablissement '.$etablissement);


//            if ($estDeMedicasure){
//                if (!in_array(4,$etablissements)){
//                    $medecin->etablissements()->attach(4);
//                    defineAsAuthor("MedecinControle",$medecin->user_id,'Add etablissement 4');
//                }
//            }
            }
        }



        //envoi des informations du compte utilisateurs par mail
        try{
            UserController::sendUserInformationViaMail($user,$password);
            return response()->json(['medecin'=>$medecin]);
        }catch (\Swift_TransportException $transportException){
            $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
            return response()->json(['medecin'=>$medecin, "message"=>$message]);

        }
    }

    /**
     * Display the specified resource.
     * @OA\Get(
     *      path="/medecin-controle/{medecin-controle}",
     *      operationId="ShowMedecinReferentList",
     *      tags={"MedecinReferent"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Show Medecin Referent",
     *      description="Returns a Medecin Referent",
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

        $medecin = MedecinControle::with(['specialite','user','etablissements'])->whereSlug($slug)->first();

        return response()->json(['medecin'=>$medecin]);

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
     * @OA\Put(
     *      path="/medecin-controle/{medecin-controle}",
     *      operationId="UpdateMedecinReferentList",
     *      tags={"MedecinReferent"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Update Medecin Referent",
     *      description="Returns a Medecin Referent",
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
     * @param MedecinControleUpdateRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(MedecinControleUpdateRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);

        $medecin= MedecinControle::with('user')->whereSlug($slug)->first();

        UserController::updatePersonalInformation($request->except('civilite','specialite_id','numero_ordre','doctor','signature'),$medecin->user->slug);
        MedecinControle::whereSlug($slug)->update($request->only([
            "specialite_id",
            "numero_ordre",
            "civilite",
        ]));

        $medecin = MedecinControle::with('specialite','user')->whereSlug($slug)->first();

        $signature = $medecin->signature;

        if($request->hasFile('signature')){
            if ($request->file('signature')->isValid()) {
                $path = $request->signature->store('public/Medecin/' . $medecin->slug . '/Signature');
                $file = str_replace('public/', '', $path);

                $medecin->signature = $file;

                $medecin->save();
            }
        }

        if (!is_null($signature))
            File::delete(public_path().'/storage/'.$signature);

        try{
            $mail = new updateSetting($medecin->user);

            Mail::to($medecin->user->email)->send($mail);

        }catch (\Swift_TransportException $transportException){
            $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
            return response()->json(['medecin'=>$medecin, "message"=>$message]);

        }

        return response()->json(['medecin'=>$medecin]);

    }

    /**
     * Remove the specified resource from storage.
     * @OA\Delete(
     *      path="/medecin-controle/{medecin-controle}",
     *      operationId="DeleteMedecinReferentList",
     *      tags={"MedecinReferent"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Delete Medecin Referent",
     *      description=" Medecin Referent Delete",
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

        $medecin = MedecinControle::with('specialite','user')->whereSlug($slug)->first();
        $medecin->delete();

        return response()->json(['medecin'=>$medecin]);

    }

    public function addEtablissement(Request $request){
        $validation = Validator::make($request->all(),[
            'etablissement_exercice_id.*'=>'sometimes|nullable|integer',
            'medecin_id'=>'required|exists:medecin_controles,slug',
        ]);

        if ($validation->fails()){
            return response()->json(['id'=>$validation->errors()],422);
        }

        $etablissements = $request->get('etablissement_exercice_id');
        $medecin = MedecinControle::whereSlug($request->get('medecin_id'))->first();

        if (!in_array(0,$etablissements)){
            foreach ($etablissements as $etablissementId){
                $etablissement = EtablissementExercice::find($etablissementId);
                //Je verifie si ce medecin n'est pas encore dans cette etablissement
                $nbre = EtablissementExerciceMedecin::where('etablissement_id','=',$etablissementId)->where('medecin_controle_id','=',$medecin->user_id)->count();
                if ($nbre ==0){
                    $medecin->etablissements()->attach($etablissement->id);
                    defineAsAuthor("Medecin",$medecin->user_id,'attach');
                }
            }
        }else{
            foreach ($medecin->etablissements as $etablissement){
                $medecin->etablissements()->detach($etablissement->id);
            }

            $etablissements = EtablissementExercice::all();
            foreach ($etablissements as $etablissement){
                $medecin->etablissements()->attach($etablissement->id);
                defineAsAuthor("MedecinControle",$medecin->user_id,'Add etablissement '.$etablissement->id);
            }
        }


        $medecin = MedecinControle::with('etablissements','specialite','user')->whereUserId($medecin->user_id)->first();

        return response()->json(['medecin'=>$medecin]);
    }

    public function removeEtablissement(Request $request){
        $validation = Validator::make($request->all(),[
            'etablissement_id.*'=>'required|integer|exists:etablissement_exercices,id',
            'medecin_id'=>'required|exists:medecin_controles,slug',
        ]);

        if ($validation->fails()){
            return response()->json(['id'=>$validation->errors()],422);
        }

        $etablissements = $request->get('etablissement_id');
        $medecin = MedecinControle::whereSlug($request->get('medecin_id'))->first();
        foreach ($etablissements as $etablissementId){
            $etablissement = EtablissementExercice::find($etablissementId);
            $medecin->etablissements()->detach($etablissement->id);
            defineAsAuthor("Medecin",$medecin->user_id,'detach etablissement '.$etablissement->name);
        }


        $medecin = MedecinControle::with('etablissements','specialite','user')->whereUserId($medecin->user_id)->first();
        return response()->json(['medecin'=>$medecin]);
    }

}
