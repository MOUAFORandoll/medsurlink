<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\ResultatRequest;
use App\Models\ResultatImagerie;
use Carbon\Carbon;

class ResultatImagerieController extends Controller
{
    use PersonnalErrors;
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

                $this->uploadFile($request,$resultat);

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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function show($slug)
    {
        $this->validatedSlug($slug, $this->table);

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
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(ResultatRequest $request, $slug)
    {
        $validation = validatedSlug($slug, $this->table);

        if(!is_null($validation))
            return $validation;

        $resultat = ResultatImagerie::findBySlug($slug);

        $this->checkIfAuthorized("Resultat", $resultat->id,"create");

        ResultatImagerie::whereSlug($slug)->update($request->validated());

        $resultat = ResultatImagerie::with(['dossier', 'consultation'])
            ->whereSlug($slug)
            ->first();

        if($request->hasFile('file')){
            $this->uploadFile($request,$resultat);
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
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function archive($slug)
    {
        $this->validatedSlug($slug, $this->table);

        $resultat = ResultatImagerie::with(['dossier', 'consultation'])
            ->whereSlug($slug)
            ->first();

        if (is_null($resultat->passed_at)) {
           $this->revealNonTransmis();

        } else {
            $resultat->archived_at = Carbon::now();
            $resultat->save();

            defineAsAuthor("Resultat", $resultat->id,'archive');

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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function transmit($slug)
    {
        $this->validatedSlug($slug, $this->table);

        $resultat = ResultatImagerie::with(['dossier', 'consultation'])
            ->whereSlug($slug)
            ->first();

        $resultat->passed_at = Carbon::now();
        $resultat->save();

        defineAsAuthor("Resultat", $resultat->id,'transmettre');

        return response()->json([
            'resultat' => $resultat
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug, $this->table);

        $resultat = ResultatImagerie::findBySlug($slug);

        $this->checkIfAuthorized("Resultat", $resultat->id,"create");

        $resultat->delete();

        return response()->json([
            'resultat' => $resultat
        ]);
    }

    public function uploadFile($request, $resultat){
        if ($request->file('file')->isValid()) {
            $path = $request->file->store('Dossier Medicale/' . $resultat->dossier->numero_dossier . '/Consultation/' . $request->consultation_medecine_generale_id);
            $file = $path;

            $resultat->file = $file;

            $resultat->save();
        }
    }
}
