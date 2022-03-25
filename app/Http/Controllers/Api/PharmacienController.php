<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Models\Pharmacien;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\PharmacienRequest;
use App\Mail\Password\PharmacienGenerated;
use App\Http\Controllers\Traits\PersonnalErrors;

class PharmacienController extends Controller
{
    use PersonnalErrors;
    protected $table = 'pharmaciens';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pharmaciens = Pharmacien::with('etablissements','user')->latest()->get();
        $distint = collect([]);

        foreach ($pharmaciens as $pharmacien){

            if ($distint->firstWhere('user_id',$pharmacien->user_id)== null){
                $distint->push($pharmacien);
            }
        }
        return response()->json(['pharmaciens'=>$distint]);
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
    public function store(PharmacienRequest $request)
    {
        $user_id = $request->get('user_id');

        if(is_null($user_id)){
            $password = str_random(10);
            $user =  User::create($request->except('user_id','sexe','etablissement_id')+['password'=> Hash::make( $password)]);
            $mail = new PharmacienGenerated($user,$password);
            Mail::to($user->email)->send($mail);
            $user_id = $user->id;
            $user->assignRole('Pharmacien');
        }else{
            $user_id = $request->get('user_id');
        }

        $pharmacien = Pharmacien::create([
            'user_id'=>$user_id,
            'etablissement_id'=>$request->etablissement_id,
            'sexe'=>$request->get('sexe','M')
        ]);

        return  response()->json(['pharmacien'=>$pharmacien]);
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

        $pharmacien = Pharmacien::with('user','etablissements')->whereSlug($slug)->first();

        return response()->json(['pharmacien'=>$pharmacien]);
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
    public function update(PharmacienRequest $request, $slug)
    {
        $this->validatedSlug($slug, $this->table);

        $user = User::whereId($request->user_id)->first();
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->telephone = $request->telephone;
        $user->save();
        Pharmacien::whereSlug($slug)->update(['sexe'=>$request->sexe]);

        $pharmacien = Pharmacien::with('user','etablissements')->whereSlug($slug)->first();

        return response()->json(['pharmacien'=>$pharmacien]);
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

        $pharmacien = Pharmacien::with('user','etablissements')->whereSlug($slug)->first();

        if (!is_null($pharmacien))
            $pharmacien->delete();

        return response()->json(['pharmacien'=>$pharmacien]);
    }
}
