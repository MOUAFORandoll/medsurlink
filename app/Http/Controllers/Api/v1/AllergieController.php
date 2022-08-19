<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\AllergieRequest;
use Illuminate\Http\Request;
use App\Models\Allergie;
use App\Models\DossierMedical;
use Illuminate\Support\Facades\Validator;

class AllergieController extends Controller
{
    use PersonnalErrors;
    protected  $table = "allergies";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dossier_medical_slug = $request->dossier_slug;
        $allergies = Allergie::whereHas('dossiers', function($query) use($dossier_medical_slug) {
            $query->where('slug', $dossier_medical_slug);
        })->latest()->get(['id', 'description', 'created_at', 'slug']);

        return response()->json(['allergies' => $allergies]);
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
     * @param AllergieRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            "dossier_slug"=>"required|exists:dossier_medicals,slug",
            "description"=>"required|string|min:3",

        ]);

        if ($validation->fails()){
            return response()->json(['error'=>$validation->errors()],419);
        }

        $dossier = DossierMedical::whereSlug($request->dossier_slug)->first();
        $allergie = Allergie::create(['description' => $request->description]);
        defineAsAuthor("Allergie", $allergie->id, 'create', $dossier->patient->user_id);
        $dossier->allergies()->attach($allergie->id);

        return response()->json(['allergie' => $allergie]);

    }


    /**
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $allergie = Allergie::whereSlug($slug)->first();

        return response()->json(['allergie'=>$allergie]);

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
     * @param AllergieRequest $request
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $slug)
    {

        $this->validatedSlug($slug,$this->table);

        $allergie = Allergie::findBySlug($slug);

       // $this->checkIfAuthorized("Allergie",$allergie->id,"create");

        Allergie::whereSlug($slug)->update($request->validate([
            "dossier_slug"=>"required|exists:dossier_medicals,slug",
            "description"=>"required|string|min:3",
        ]));

        $allergie = $allergie->fresh();

        return response()->json(['allergie' => $allergie]);
    }


    /**
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $allergie = Allergie::findBySlug($slug);

        //$this->checkIfAuthorized("Allergie",$allergie->id,"create");

        $allergie->delete();

        return response()->json(['allergie' => $slug]);
    }
}
