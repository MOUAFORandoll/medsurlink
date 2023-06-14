<?php

namespace App\Http\Controllers\Api\v2\Globale;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GroupeUtilisateur;
use Illuminate\Support\Str;

class GroupeUtilisateurController extends Controller
{

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        $list = $request->list ?? "";
        $size = $request->size ?? 25;
        if($list == "all"){
            $groupe_utilisateurs = GroupeUtilisateur::orderBy('nom', 'asc')->get(['id', 'nom']);
        }else{
            $groupe_utilisateurs = GroupeUtilisateur::withCount('users')->latest()->paginate($size);
        }
        return $this->successResponse($groupe_utilisateurs);
    }

    /**
     * @param $groupe_utilisateur
     *
     * @return mixed
     */
    public function show($groupe_utilisateur)
    {
        $groupe_utilisateur = GroupeUtilisateur::where('id', $groupe_utilisateur)->orWhere("uuid", $groupe_utilisateur)->first();
        return $this->successResponse($groupe_utilisateur->load('users'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validations());

        $groupe_utilisateur = GroupeUtilisateur::create(['uuid' => Str::uuid(), 'nom' => $request->nom, 'description' => $request->description]);

        $groupe_utilisateur->users()->sync($request->users);

        return $this->successResponse($groupe_utilisateur);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $groupe_utilisateur
     *
     * @return mixed
     */
    public function update(Request $request, $groupe_utilisateur)
    {
        $this->validate($request, $this->validations(true));
        return $this->successResponse($groupe_utilisateur);
    }

    public function assignRole(Request $request, $groupe_utilisateur){
        return $this->successResponse($groupe_utilisateur);
    }

    /**
     * @param $groupe_utilisateur
     *
     * @return mixed
     */
    public function destroy($groupe_utilisateur)
    {
        return $this->successResponse($groupe_utilisateur);
    }

    public function validations($is_update = false){
        $rules = [
            'nom' => 'required',
            'description' => 'required',
            'users' => 'required|array'
        ];
        return $rules;
    }
}
