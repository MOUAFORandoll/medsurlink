<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ResultatRequest;
use App\Models\ResultatImagerie;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResultatImagerieController extends Controller
{
    protected $table = "resultat_imageries";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resultats = ResultatImagerie::with(['dossier', 'consultation'])->get();

        return response()->json([
            'resultats' => $resultats
        ]);
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
     * @param ResultatRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResultatRequest $request)
    {
        if($request->hasFile('file')) {
            if ($request->file('file')->isValid()) {
                $resultat = ResultatImagerie::create($request->validated());

                $path = $request->file->store('Dossier Medicale/' . $resultat->dossier->numero_dossier . '/Consultation/' . $request->consultation_medecine_generale_id);
                $file = $path;

                $resultat->file = $file;

                $resultat->save();

                defineAsAuthor("Resultat", $resultat->id,'create');

                return response()->json([
                    'resultat' => $resultat
                ]);
            }

            return response()->json(
                [
                    'file' => 'File is not valid'
                ],
                422
            );
        } else {
            return response()->json(
                [
                    'file' => "File required"
                ],
                422
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $validation = validatedSlug($slug, $this->table);

        if(!is_null($validation))
            return $validation;

        $resultat = ResultatImagerie::with(['dossier', 'consultation'])
            ->whereSlug($slug)
            ->first();

        return response()->json([
            'resultat' => $resultat
        ]);
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
     * @param ResultatRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     */
    public function update(ResultatRequest $request, $slug)
    {
        $validation = validatedSlug($slug, $this->table);

        if(!is_null($validation))
            return $validation;

        $resultat = ResultatImagerie::findBySlug($slug);

        $isAuthor = checkIfIsAuthorOrIsAuthorized("Resultat", $resultat->id,"create");

        if(!$isAuthor->getOriginalContent()){
            return response()->json(
                [
                    'error' => "Vous ne pouvez modifié un élement que vous n'avez crée"
                ],
                401
            );
        }

        ResultatImagerie::whereSlug($slug)->update($request->validated());

        $resultat = ResultatImagerie::with(['dossier', 'consultation'])
            ->whereSlug($slug)
            ->first();

        if($request->hasFile('file')){
            if ($request->file('file')->isValid()) {
                $path = $request->file->store('Dossier Medicale/' . $resultat->dossier->numero_dossier . '/Consultation/' . $request->consultation_medecine_generale_id);
                $file = $path;

                $resultat->file = $file;

                $resultat->save();
            }
        }

        return response()->json([
            'resultat' => $resultat
        ]);
    }

    /**
     * Archive the specified resource in storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     */
    public function archive($slug)
    {
        $validation = validatedSlug($slug, $this->table);

        if(!is_null($validation))
            return $validation;

        $resultat = ResultatImagerie::with(['dossier', 'consultation'])
            ->whereSlug($slug)
            ->first();

        if (is_null($resultat->passed_at)) {
            $transmission = [];
            $transmission['nonTransmis'][0] = "Ce resultat n'a pas encoré été transmis";

            return response()->json(['error'=>$transmission],419 );
        } else {
            $resultat->archived_at = Carbon::now();
            $resultat->save();

            return response()->json([
                'resultat' => $resultat
            ]);
        }
    }

    /**
     * Transmit the specified resource in storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     */
    public function transmit($slug)
    {
        $validation = validatedSlug($slug, $this->table);

        if(!is_null($validation))
            return $validation;

        $resultat = ResultatImagerie::with(['dossier', 'consultation'])
            ->whereSlug($slug)
            ->first();

        $resultat->passed_at = Carbon::now();
        $resultat->save();

        return response()->json([
            'resultat' => $resultat
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $validation = validatedSlug($slug, $this->table);

        if(!is_null($validation))
            return $validation;

        $resultat = ResultatImagerie::findBySlug($slug);

        $isAuthor = checkIfIsAuthorOrIsAuthorized("Resultat", $resultat->id,"create");

        if($isAuthor->getOriginalContent() == false){
            return response()->json(
                [
                    'error' => "Vous ne pouvez modifié un élement que vous n'avez crée"
                ],
                401
            );
        }

        $resultat->delete();

        return response()->json([
            'resultat' => $resultat
        ]);
    }
}
