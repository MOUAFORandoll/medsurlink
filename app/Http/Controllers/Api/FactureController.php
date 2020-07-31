<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\FactureRequest;
use App\Mail\Facture\MailRappel;
use App\Mail\Facture\MailRecouvrement;
use App\Models\Facture;
use App\Models\FacturePrestation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class FactureController extends Controller
{
    use PersonnalErrors;
    protected $table = 'factures';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(FactureRequest $request)
    {
        $facture = Facture::create($request->except('prestation'));

        if ($request->hasFile('documents')) {
            $this->uploadFile($request, $facture);
        }

       $prestations =  $request->get('prestation');

        if ($prestations != 'null' && $prestations != null){
            foreach ($prestations as $prestation){
                FacturePrestation::create($prestation + ['facture_id'=>$facture->id]);
            }
        }

        return response()->json(['facture'=>$facture]);
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

        $facture = Facture::with('dossier.patient.user','files','etablissement','prestations.prestation_etablissement.prestation')
            ->whereSlug($slug)->first();

        return response()->json(['facture'=>$facture]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FactureRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);

        Facture::whereSlug($slug)->update($request->except('prestation','facture'));

        $facture = Facture::whereSlug($slug)->first();

        return response()->json(['facture'=>$facture]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $facture = Facture::whereSlug($slug)->first();

        if (!is_null($facture))
            $facture->delete();

        return response()->json(['facture'=>$facture]);
    }

    public function uploadFile($request, $facture){
        foreach ($request->documents as $document){
            $path = $document->storeAs('public/DossierMedicale/' . $facture->dossier->numero_dossier . '/Facture' . $facture->id,
                $document->getClientOriginalName());

            $file = str_replace('public/','',$path);

            $file = \App\Models\File::create([
                'fileable_type'=>'Facture',
                'fileable_id'=>$facture->id,
                'nom'=>$document->getClientOriginalName(),
                'extension'=>$document->getClientOriginalExtension(),
                'chemin'=>$file,
            ]);

            defineAsAuthor("File",$file->id,'create');

        }
    }

    public function rappel($slug){

        $this->validatedSlug($slug,$this->table);

        $facture = Facture::with('dossier.patient.user','files','etablissement','prestations.prestation_etablissement.prestation')
            ->whereSlug($slug)->first();
        $souscripteurs = [];
        if (!is_null($facture)){
            $souscripteur = $facture->dossier->patient->souscripteur;
            if (!is_null($souscripteur)){
                array_push($souscripteurs,$souscripteur);
            }
            $financeurs = $facture->dossier->patient->financeurs;
            foreach ($financeurs as $financeur){
                array_push($souscripteurs,$financeur->financable);
            }

            foreach ($souscripteurs as $souscripteur){
                $mail = new MailRappel($facture,$souscripteur);
                Mail::to($souscripteur->user->email)->send($mail);
            }
        }
    }

    public function mailRecouvrement($slug){
        $this->validatedSlug($slug,$this->table);

        $facture = Facture::with('dossier.patient.user','files','etablissement','prestations.prestation_etablissement.prestation')
            ->whereSlug($slug)->first();
        $souscripteurs = [];
        if (!is_null($facture)){
            $souscripteur = $facture->dossier->patient->souscripteur;
            if (!is_null($souscripteur)){
                array_push($souscripteurs,$souscripteur);
            }
            $financeurs = $facture->dossier->patient->financeurs;
            foreach ($financeurs as $financeur){
                array_push($souscripteurs,$financeur->financable);

            }
            foreach ($souscripteurs as $souscripteur){
                $mail = new MailRecouvrement($facture,$souscripteur);
                Mail::to($souscripteur->user->email)->send($mail);
            }

            $facture->statut = 'En recouvrement';
            $facture->save();
        }
    }
}
