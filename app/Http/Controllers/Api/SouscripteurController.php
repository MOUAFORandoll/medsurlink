<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\SouscripteurStoreRequest;
use App\Http\Requests\SouscripteurUpdateRequest;
use App\Mail\updateSetting;
use App\Mail\RappelAffiliation;
use App\Models\Souscripteur;
use App\Models\AffiliationSouscripteur;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Netpok\Database\Support\DeleteRestrictionException;

class SouscripteurController extends Controller
{
    use PersonnalErrors;
    protected $table = "souscripteurs";

    /**
     * Display a listing of the resource.
     * @OA\Get(
     *      path="/souscripteur",
     *      operationId="getSouscripteurList",
     *      tags={"Souscripteur"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Get list of souscripteur",
     *      description="Returns list of souscripteur",
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
        $souscripteurs = Souscripteur::with('patients','user','financeurs.patients','affiliation')->get();
        return response()->json(['souscripteurs'=>$souscripteurs]);
    }

    public function listingSouscripteur($souscripteur_search){
        $souscripteurs = Souscripteur::whereHas('user', function($query) use ($souscripteur_search){
            $query->where('nom', 'like',  '%'.$souscripteur_search.'%')
            ->orwhere('prenom', 'like',  '%'.$souscripteur_search.'%')
            ->orwhere('email', 'like',  '%'.$souscripteur_search.'%')
            ->orwhere(DB::raw('CONCAT_WS(" ", nom, prenom)'), 'like',  '%'.$souscripteur_search.'%')
            ->orwhere(DB::raw('CONCAT_WS(" ", prenom, nom)'), 'like',  '%'.$souscripteur_search.'%');
        })->with(['user:id,nom,prenom,email'])->select('user_id')->get();
        return response()->json(['souscripteurs'=>$souscripteurs]);

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

    public function storeSouscripteur(SouscripteurStoreRequest $request){
        $this->store($request);
    }
    /**
     * Store a newly created resource in storage.
     * @OA\Post(
     *      path="souscripteur/{souscripteur}",
     *      operationId="StoreSouscripteurList",
     *      tags={"Souscripteur"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Store souscripteur",
     *      description="Returns souscripteur",
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
     * @param SouscripteurStoreRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(SouscripteurStoreRequest $request)
    {
        //Création des informations utilisateurs
        $userResponse =  UserController::generatedUser($request,'Souscripteur');
        if ($userResponse->status() == 419)
            return $userResponse;

        $user = $userResponse->getOriginalContent()['user'];
        $password = $userResponse->getOriginalContent()['password'];
        $user->assignRole('Souscripteur');

        //Creation du compte souscripteurs
        $age = 0;

        if (!is_null($request->date_de_naissance)){
            $age = evaluateYearOfOld($request->date_de_naissance);
        }
        $souscripteur = Souscripteur::create($request->validated() + ['user_id' => $user->id,'age'=>$age]);

        defineAsAuthor("Souscripteur",$souscripteur->user_id,'create');

        //envoi des informations du compte utilisateurs par mail
        try{
            UserController::sendUserInformationViaMail($user,$password);
            return response()->json(['souscripteur'=>$souscripteur]);
        }catch (\Swift_TransportException $transportException){
            $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
            return response()->json(['souscripteur'=>$souscripteur, "message"=>$message]);
        }


    }

    /**
     * Display the specified resource.
     * @OA\Get(
     *      path="souscripteur/{souscripteur}",
     *      operationId="ShowSouscripteurList",
     *      tags={"Souscripteur"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Show souscripteur",
     *      description="Returns souscripteur",
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

        $souscripteur = Souscripteur::has('patients.user')->with('user','patients.user','patients.dossier','financeurs.patients.user','financeurs.patients.dossier','affiliation')->whereSlug($slug)->first();

        $souscripteur->updatePatientDossier();
        $souscripteur->patients = collect($souscripteur->patients)->unique('user_id');
        /* foreach($souscripteur->patients as $souscripteu){
            $souscripteu->patients = $souscripteu->patients()->unique('user_id');
            $new_scouscripteur->push($souscripteu);
        } */
        return response()->json([ 'souscripteur' => $souscripteur ]);

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
     * Show the form for rappel the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rappelAffilie($slug)
    {
        $this->validatedSlug($slug,$this->table);
        $souscripteur= Souscripteur::with('user')->whereSlug($slug)->first();
        try{
            $mail = new RappelAffiliation($souscripteur);
            Mail::to($souscripteur->user->email)->send($mail);
        }catch (\Swift_TransportException $transportException){
            $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
            return response()->json(['souscripteur'=>$souscripteur, "message"=>$message]);

        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cim()
    {
        $souscripteurs = AffiliationSouscripteur::with('souscripteur','souscripteur.user','typeContrat')
        ->orderBy("created_at","desc")
        ->get();
        return response()->json(['souscripteurs'=>$souscripteurs]);
    }
    /**
     * Update the specified resource in storage.
     * @OA\Put(
     *      path="souscripteur/{souscripteur}",
     *      operationId="UpdateSouscripteurList",
     *      tags={"Souscripteur"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Show souscripteur",
     *      description="Returns souscripteur",
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
     * @param SouscripteurUpdateRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(SouscripteurUpdateRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);

        $souscripteur= Souscripteur::with('user')->whereSlug($slug)->first();

        UserController::updatePersonalInformation($request->except('subscriber','sexe','date_de_naissance'),$souscripteur->user->slug);

        $age = 0;

        if (!is_null($request->date_de_naissance)){
            $age = evaluateYearOfOld($request->date_de_naissance);
        }

        Souscripteur::whereSlug($slug)->update($request->only(['sexe','date_de_naissance'])+['age'=>$age]);

        //Calcul de l'age du souscripteur
        $souscripteur = Souscripteur::with('user','patients')->whereSlug($slug)->first();

        try{
            $mail = new updateSetting($souscripteur->user);

            Mail::to($souscripteur->user->email)->send($mail);

        }catch (\Swift_TransportException $transportException){
            $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
            return response()->json(['souscripteur'=>$souscripteur, "message"=>$message]);

        }

        return response()->json(['souscripteur'=>$souscripteur]);

    }

    /**
     * Remove the specified resource from storage.
     * @OA\Delete(
     *      path="souscripteur/{souscripteur}",
     *      operationId="DeleteSouscripteurList",
     *      tags={"Souscripteur"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Delete souscripteur",
     *      description="Delete a souscripteur",
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
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        try{
            $souscripteur = Souscripteur::with('user','patients')->whereSlug($slug)->first();
            $souscripteur->delete();
            return response()->json(['souscripteur'=>$souscripteur]);

        }catch (DeleteRestrictionException $deleteRestrictionException){
            $this->revealError('deletingError',$deleteRestrictionException->getMessage());
        }

    }
}
