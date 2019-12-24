<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\ResultatRequest;
use App\Models\ResultatLabo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ResultatLaboController extends Controller
{
    use PersonnalErrors;
    protected $table = "resultat_labos";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resultats = ResultatLabo::with(['dossier', 'consultation'])->get();

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
                $resultat = ResultatLabo::create($request->validated());

                $this->uploadFile($request,$resultat);

                defineAsAuthor("Resultat", $resultat->id,'create',$resultat->dossier->patient->user_id);

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
        }else{
            $resultat = ResultatLabo::create($request->validated());

            defineAsAuthor("Resultat", $resultat->id,'create',$resultat->dossier->patient->user_id);

            return response()->json([
                'resultat' => $resultat
            ]);
        }
//        else {
//            return response()->json(
//                [
//                    'file' => "File required"
//                ],
//                422
//            );
//        }
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

        $resultat = ResultatLabo::with(['dossier.patient.user','dossier.consultationsMedecine', 'consultation'])
            ->whereSlug($slug)
            ->first();
        $motifIsAuthor = checkIfIsAuthorOrIsAuthorized("Resultat",$resultat->id,"create");
        $resultat['isAuthor'] = $motifIsAuthor->getOriginalContent();
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
        $this->validatedSlug($slug, $this->table);

        $resultat = ResultatLabo::findBySlug($slug);

        $this->checkIfAuthorized("Resultat", $resultat->id,"create");

        ResultatLabo::whereSlug($slug)->update($request->validated());

        $resultat = ResultatLabo::with(['dossier', 'consultation'])
            ->whereSlug($slug)
            ->first();

        $file = $resultat->file;

        if($request->hasFile('file')){
            $this->uploadFile($request,$resultat);
        }

        if (!is_null($file))
            File::delete(public_path().'/storage/'.$file);

        return response()->json([
            'resultat' => $resultat
        ]);
    }

    /**
     * Archive the specified resource in storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function archive($slug)
    {
        $this->validatedSlug($slug, $this->table);

        $resultat = ResultatLabo::with(['dossier', 'consultation'])
            ->whereSlug($slug)
            ->first();

        if (is_null($resultat->passed_at)) {
            $this->revealNonTransmis();

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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function transmit($slug)
    {
        $this->validatedSlug($slug, $this->table);

        $resultat = ResultatLabo::with(['dossier', 'consultation'])
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
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($slug)
    {
        $validation = validatedSlug($slug, $this->table);

        if(!is_null($validation))
            return $validation;

        $resultat = ResultatLabo::with('dossier')->whereSlug($slug)->first();

        $this->checkIfAuthorized("Resultat", $resultat->id,"create");

        $resultat->delete();
        File::delete(public_path().'/storage/'.$resultat->file);

        return response()->json([
            'resultat' => $resultat
        ]);
    }

    public function uploadFile($request, $resultat){
        if ($request->file('file')->isValid()) {
            $path = $request->file->store('public/DossierMedicale/' . $resultat->dossier->numero_dossier . '/Consultation/' . $request->consultation_medecine_generale_id);
            $file = str_replace('public/','',$path);

            $resultat->file = $file;

            $resultat->save();
        }
    }
}
