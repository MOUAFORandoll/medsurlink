<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\AssociationRequest;
use App\Models\Association;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;

class AssociationController extends Controller
{
    protected $table = 'associations';
    use PersonnalErrors;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $associations = Association::all();

        return  response()->json(['associations'=>$associations]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $value
     * @return \Illuminate\Http\Response
     */

    // public function specialList($value)
    // {
    //     $result=[];
    //     $associations = Association::with(['user'])->restrictUser()->get();

    //     // $patients = Patient::with(['souscripteur','dossier', 'etablissements', 'user','affiliations','financeurs.financable'])->where('age', '=', intval($value))->orWhereHas('user', function($q) use ($value){ $q->Where('nom', 'like', '%'.strtolower($value).'%'); $q->orWhere('prenom', 'like', '%'.strtolower($value).'%'); $q->orWhere('email', 'like', '%'.strtolower($value).'%');})->orWhereHas('dossier', function($q) use ($value){ $q->Where('numero_dossier', '=', intval($value)); })->restrictUser()->get();
    //     // return $patients;
    //     foreach($associations as $p){
    //         if($p->user!=null){
    //             if(strpos(strtolower($p->responsable->nom),strtolower($value)) || 
    //         strpos(strtolower($p->user->prenom),strtolower($value)) || 
    //         strpos(strtolower(strval($p->dossier->numero_dossier)),strtolower($value)) || 
    //         strpos(strtolower(strval($p->age)),strtolower($value)) ||
    //         strpos(strtolower($p->user->email),strtolower($value))) 
    //         array_push($result,$p);
    //         }
            
    //     }
    //     return $result;
        
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssociationRequest $request)
    {
        //Creation de l'utilisateur dans la table user et génération du mot de passe
        $password = str_random(10);
       //Attribution du rôle Association 
        $user = User::create([
            'nom'=>$request->nom,
            'prenom'=>$request->prenom,
            'email'=>$request->email,
            'nationalite'=>null,
            'quartier'=>$request->quartier,
            'code_postal'=>$request->code_postal,
            'ville'=>$request->ville,
            'pays'=>$request->pays,
            'telephone'=>$request->telephone,
            'adresse'=>$request->adresse,
            'isMedicasure'=>0,
            'isNotice'=>0,
            'password'=>Hash::make($request->password),
            'decede'=>'non'
        ]);
        $user->assignRole('Association');
       
        $association = Association::create($request->validated());
        $association->responsable = $user->id;
        $association->save();
        try{
            UserController::sendUserInformationViaMail($user,$password);
            return  response()->json(['association'=>$association]);
        }catch (\Swift_TransportException $transportException){
            $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
            return response()->json(['association'=>$association, "message"=>$message]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $association = Association::whereSlug($slug)->first();

        return  response()->json(['association'=>$association]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(AssociationRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);

        Association::whereSlug($slug)->update($request->validated());

        $association = Association::whereSlug($slug)->first();

        return  response()->json(['association'=>$association]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $association = Association::whereSlug($slug)->first();

        $association->delete();

        return  response()->json(['association'=>$association]);
    }
}
