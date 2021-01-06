<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\SouscripteurStoreRequest;
use App\Http\Requests\SouscripteurUpdateRequest;
use App\Mail\updateSetting;
use App\Models\Souscripteur;
use Illuminate\Support\Facades\Mail;
use Netpok\Database\Support\DeleteRestrictionException;

class SouscripteurController extends Controller
{
    use PersonnalErrors;
    protected $table = "souscripteurs";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $souscripteurs = Souscripteur::with('patients','user','financeurs.patients')->get();
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

    /**
     * Store a newly created resource in storage.
     *
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $souscripteur = Souscripteur::with('user','patients.user','patients.dossier','financeurs.patients.user','financeurs.patients.dossier')->whereSlug($slug)->first();

        $souscripteur->updatePatientDossier();
        return response()->json(['souscripteur'=>$souscripteur]);

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
     *
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
