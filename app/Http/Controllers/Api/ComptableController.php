<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\ComptableRequest;
use App\Mail\Password\PasswordGenerated;
use App\Models\Comptable;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ComptableController extends Controller
{
    use PersonnalErrors;
    protected $table = 'comptables';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comptables = Comptable::with('etablissements','user')->get();
        $distint = collect([]);

        foreach ($comptables as $comptable){

            if ($distint->firstWhere('user_id',$comptable->user_id)== null){
                $distint->push($comptable);
            }
        }
        return response()->json(['comptables'=>$distint]);
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
    public function store(ComptableRequest $request)
    {
        $user_id = $request->get('user_id');

        if(is_null($user_id)){
            $password = str_random(10);
            $user =  User::create($request->except('user_id','sexe','etablissement_id')+['password'=> Hash::make( $password)]);
            $mail = new PasswordGenerated($user,$password);
            Mail::to($user->email)->send($mail);
            $user_id = $user->id;
            $user->assignRole('Etablissement');
        }else{
            $user_id = $request->get('user_id');
        }

        $comptable = Comptable::create([
            'user_id'=>$user_id,
            'etablissement_id'=>$request->etablissement_id,
            'sexe'=>$request->get('sexe','M')
        ]);

        return  response()->json(['comptable'=>$comptable]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show(string $slug)
    {
        $this->validatedSlug($slug, $this->table);

        $comptable = Comptable::with('user','etablissements')->whereSlug($slug)->first();

        return response()->json(['comptable'=>$comptable]);
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
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(ComptableRequest $request, $slug)
    {
        $this->validatedSlug($slug, $this->table);

        $user = User::whereId($request->user_id)->first();
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->telephone = $request->telephone;
        $user->save();
        Comptable::whereSlug($slug)->update(['sexe'=>$request->sexe]);

        $comptable = Comptable::with('user','etablissements')->whereSlug($slug)->first();

        return response()->json(['comptable'=>$comptable]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {

        $this->validatedSlug($slug, $this->table);

        $comptable = Comptable::with('user','etablissements')->whereSlug($slug)->first();

        if (!is_null($comptable))
            $comptable->delete();

        return response()->json(['comptable'=>$comptable]);
    }
}
