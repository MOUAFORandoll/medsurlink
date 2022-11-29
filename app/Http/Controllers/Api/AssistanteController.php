<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\AssistanteRequest;
use App\Mail\Password\AssistantGenerated;
use App\Models\Assistante;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AssistanteController extends Controller
{
    use PersonnalErrors;
    protected $table = 'assistantes';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assistantes = Assistante::with('etablissements','user')->latest()->get();
        $distint = collect([]);

        foreach ($assistantes as $assistante){

            if ($distint->firstWhere('user_id',$assistante->user_id)== null){
                $distint->push($assistante);
            }
        }
        return response()->json(['assistantes'=>$distint]);
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
    public function store(AssistanteRequest $request)
    {
        $user_id = $request->get('user_id');

        if(is_null($user_id)){
            $password = str_random(10);
            $user =  User::create($request->except('user_id','sexe','etablissement_id')+['password'=> Hash::make( $password)]);
            $mail = new AssistantGenerated($user,$password);
            $when = now()->addMinutes(1);
            Mail::to($user->email)->later($when, $mail);
            $user_id = $user->id;
            $user->assignRole('Assistante');
        }else{
            $user_id = $request->get('user_id');
        }

        $assistante = Assistante::create([
            'user_id'=>$user_id,
            'etablissement_id'=>$request->etablissement_id,
            'sexe'=>$request->get('sexe','M')
        ]);

        return  response()->json(['assistante'=>$assistante]);
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

        $assistante = Assistante::with('user','etablissements')->whereSlug($slug)->first();

        return response()->json(['assistante'=>$assistante]);
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
    public function update(AssistanteRequest $request, $slug)
    {
        $this->validatedSlug($slug, $this->table);

        $user = User::whereId($request->user_id)->first();
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->telephone = $request->telephone;
        $user->save();
        Assistante::whereSlug($slug)->update(['sexe'=>$request->sexe]);

        $assistante = Assistante::with('user','etablissements')->whereSlug($slug)->first();

        return response()->json(['assistante'=>$assistante]);
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

        $assistante = Assistante::with('user','etablissements')->whereSlug($slug)->first();

        if (!is_null($assistante))
            $assistante->delete();

        return response()->json(['assistante'=>$assistante]);
    }
}
