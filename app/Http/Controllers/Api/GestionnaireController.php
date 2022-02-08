<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\GestionnaireStoreRequest;
use App\Http\Requests\GestionnaireUpdateRequest;
use App\Mail\updateSetting;
use App\Models\Gestionnaire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class GestionnaireController extends Controller
{
    use PersonnalErrors;
    protected $table = "gestionnaires";
    /**
     * Display a listing of the resource.
     * @OA\Get(
     *      path="/gestionnaire",
     *      operationId="getGestionnaireList",
     *      tags={"Gestionnaire"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Get list of gestionnaire",
     *      description="Returns list of gestionnaire",
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
        $gestionnaires = Gestionnaire::with('user')->get();

        foreach ($gestionnaires as $gestionnaire){
           $gestionnaire->updateGestionnaire();
        }

        return response()->json(['gestionnaires'=>$gestionnaires]);
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
     *      path="/gestionnaire/{gestionnaire}",
     *      operationId="storeGestionnaire", 
     *      tags={"Gestionnaire"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Store gestionnaire",
     *      description="Returns a gestionnaire",
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GestionnaireStoreRequest $request)
    {
        if (is_null($request->get('nationalite'))){
            $this->revealError('nationalite','nationalite field is required');
        }

        //Création des informations utilisateurs
        $userResponse =  UserController::generatedUser($request);

        $user = $userResponse->getOriginalContent()['user'];
        $password = $userResponse->getOriginalContent()['password'];
        $user->assignRole('Gestionnaire');

        $gestionnaire = Gestionnaire::create($request->validated() + ['user_id' => $user->id]);
        defineAsAuthor("Gestionnaire",$gestionnaire->user_id,'create');

        //envoi des informations du compte utilisateurs par mail
        try{
            UserController::sendUserInformationViaMail($user,$password);
            return response()->json(['gestionnaire'=>$gestionnaire]);
        }catch (\Swift_TransportException $transportException){
            $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
            return response()->json(['gestionnaire'=>$gestionnaire, "message"=>$message]);

        }


    }

    /**
     * Display the specified resource.
     * @OA\Get(
     *      path="/gestionnaire/{gestionnaire}",
     *      operationId="showGestionnaire", 
     *      tags={"Gestionnaire"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Show gestionnaire",
     *      description="Returns a gestionnaire",
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
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $gestionnaire = Gestionnaire::with('user')->whereSlug($slug)->first();

        $gestionnaire->updateGestionnaire();

        return response()->json(['gestionnaire'=>$gestionnaire]);

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
     *      path="/gestionnaire/{gestionnaire}",
     *      operationId="updateGestionnaire", 
     *      tags={"Gestionnaire"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Update gestionnaire",
     *      description="Returns a gestionnaire",
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
     * @param GestionnaireUpdateRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(GestionnaireUpdateRequest $request, $slug)
    {
        if (is_null($request->get('nationalite'))){
            $this->revealError('nationalite','nationalite field is required');
        }

        $this->validatedSlug($slug,$this->table);

        $gestionnaire = Gestionnaire::with('user')->whereSlug($slug)->first();

        UserController::updatePersonalInformation($request->except('civilite','manager'),$gestionnaire->user->slug);

        $isAuthor = checkIfIsAuthorOrIsAuthorized("Gestionnaire",$gestionnaire->user_id,"create");
        if(!$isAuthor->getOriginalContent() && $gestionnaire->user_id != Auth::id())
            {
                $this->revealAccesRefuse();
            }

        Gestionnaire::whereSlug($slug)->update($request->validated());

        $gestionnaire = Gestionnaire::with('user')->whereSlug($slug)->first();

        try{
        $mail = new updateSetting($gestionnaire->user);

        Mail::to($gestionnaire->user->email)->send($mail);

        }catch (\Swift_TransportException $transportException){
            $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
            return response()->json(['gestionnaire'=>$gestionnaire, "message"=>$message]);

        }
        return response()->json(['gestionnaire'=>$gestionnaire]);

    }

    /**
     * Remove the specified resource from storage.
     * @OA\Delete(
     *      path="/gestionnaire/{gestionnaire}",
     *      operationId="deleteGestionnaire", 
     *      tags={"Gestionnaire"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Delete gestionnaire",
     *      description="Returns list of gestionnaire",
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

        $gestionnaire = Gestionnaire::whereSlug($slug)->first();
        $gestionnaire->delete();

        return response()->json(['gestionnaire'=>$gestionnaire]);

    }

}
