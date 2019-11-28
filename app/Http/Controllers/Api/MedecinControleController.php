<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\MedecinControleStoreRequest;
use App\Http\Requests\MedecinControleUpdateRequest;
use App\Models\MedecinControle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class MedecinControleController extends Controller
{
    use PersonnalErrors;
    protected $table = "medecin_controles";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medecins = MedecinControle::with(['specialite','user'])->get();
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
     *
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $medecin = MedecinControle::with('specialite','user')->whereSlug($slug)->first();

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
     *
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
        MedecinControle::whereSlug($slug)->update($request->validated());

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

        return response()->json(['medecin'=>$medecin]);

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

        $medecin = MedecinControle::with('specialite','user')->whereSlug($slug)->first();
        $medecin->delete();

        return response()->json(['medecin'=>$medecin]);

    }

}
