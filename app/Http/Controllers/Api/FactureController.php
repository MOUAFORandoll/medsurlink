<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\FactureRequest;
use App\Mail\Facture\MailRappel;
use App\Mail\Facture\MailRecouvrement;
use App\Models\Facture;
use App\Models\FacturePrestation;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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
        $facture = Facture::create($request->except('prestation')+['creator'=>Auth::id()]);

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
        $total = 0;
        foreach ($facture->prestations as $prestation){
            if ($prestation->statut == 'Validé'){
                $total = $total+$prestation->prestation_etablissement->prix - $prestation->prestation_etablissement->reduction;
            }
        }
        $souscripteurs = [];
        $data = compact('facture','total');

        $pdf = PDF::loadView('facture.definitive',$data);
        $user = $facture->dossier->patient->user;
        if ($user->decede == 'non') {
            $nom = ucfirst($facture->dossier->patient->user->nom);
            $prenom = is_null($facture->dossier->patient->user->prenom) ? '' : $facture->dossier->patient->user->prenom;
            $prenom = ucfirst($prenom);
            $date = $facture->date_facturation;
            $attachName = str_replace(' ', '_', 'Facture_' . $nom . '_' . $prenom . '_' . $date . '.pdf');
            $path = storage_path() . '/app/public/pdf/' . $attachName;
            $pdf->save($path);
            $attachPath = '/storage/pdf/' . $attachName;
            if (!is_null($facture)) {
                $souscripteur = $facture->dossier->patient->souscripteur;
                if (!is_null($souscripteur)) {
                    array_push($souscripteurs, $souscripteur);
                }
                $financeurs = $facture->dossier->patient->financeurs;
                foreach ($financeurs as $financeur) {
                    array_push($souscripteurs, $financeur->financable);
                }

                foreach ($souscripteurs as $souscripteur) {
                    $mail = new MailRappel($facture, $souscripteur, $attachPath, $total);
                    Mail::to($souscripteur->user->email)->send($mail);
                    Log::info('envoi de mail de rappel ' . $souscripteur->user->email);
                }
            }
        }
    }

    public function mailRecouvrement($slug){
        $this->validatedSlug($slug,$this->table);

        $facture = Facture::with('dossier.patient.user','files','etablissement','prestations.prestation_etablissement.prestation')
            ->whereSlug($slug)->first();
        $souscripteurs = [];
        $total = 0;
        foreach ($facture->prestations as $prestation){
            if ($prestation->statut == 'Validé'){
                $total = $total+$prestation->prestation_etablissement->prix - $prestation->prestation_etablissement->reduction;
            }
        }
        // If the contract does not exists, then create it
        $data = compact('facture','total');

        $pdf = PDF::loadView('facture.definitive',$data);
        $user = $facture->dossier->patient->user;
        if ($user->decede == 'non') {
            $nom = ucfirst($facture->dossier->patient->user->nom);
            $prenom = is_null($facture->dossier->patient->user->prenom) ? '' : $facture->dossier->patient->user->prenom;
            $prenom = ucfirst($prenom);
            $date = $facture->date_facturation;
            $attachName = str_replace(' ', '_', 'Facture_' . $nom . '_' . $prenom . '_' . $date . '.pdf');
            $path = storage_path() . '/app/public/pdf/' . $attachName;
            $pdf->save($path);
            $attachPath = '/storage/pdf/' . $attachName;
            if (!is_null($facture)) {
                $souscripteur = $facture->dossier->patient->souscripteur;
                if (!is_null($souscripteur)) {
                    array_push($souscripteurs, $souscripteur);
                }
                $financeurs = $facture->dossier->patient->financeurs;
                foreach ($financeurs as $financeur) {
                    array_push($souscripteurs, $financeur->financable);

                }
                foreach ($souscripteurs as $souscripteur) {
                    $mail = new MailRecouvrement($facture, $souscripteur, $attachPath,$total);
                    Mail::to($souscripteur->user->email)->send($mail);
                    Log::info('envoi de mail de recouvrement ' . $souscripteur->user->email);

                }

                $facture->statut = 'En recouvrement';
                $facture->save();
            }
        }
    }
}
