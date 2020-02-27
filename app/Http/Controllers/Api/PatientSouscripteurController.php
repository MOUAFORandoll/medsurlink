<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\PatientSouscripteurRequest;
use App\Mail\updateSetting;
use App\Models\Patient;
use App\Models\PatientSouscripteur;
use App\Models\Souscripteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PatientSouscripteurController extends Controller
{
    use PersonnalErrors;
    protected $table = 'patient_souscripteurs';
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
    public function store(PatientSouscripteurRequest $request)
    {
        $financeurs = $request->get('financable_id');
        $patient = Patient::whereSlug($request->get('patient_id'))->first();
        foreach ($financeurs as $financeur){
            $financeur = PatientSouscripteur::create([
                'financable_type'=>$request->get('financable_type'),
                'financable_id'=>$financeur,
                'patient_id'=>$patient->user_id
            ]);

            defineAsAuthor('PatientSouscripteur',$financeur->id,'create',$patient->user_id);

            if (!is_null($financeur->financable)){
                if (!is_null($financeur->financable->user)){
                    $mail = new updateSetting($financeur->financable->user);
                    Mail::to($financeur->financable->user->email)->send($mail);
                }
            }
        }

        $patient = Patient::with(['souscripteur.user','user','affiliations','etablissements','financeurs.financable.user'])->restrictUser()->whereSlug($patient->slug)->first();
        if (!is_null($patient->user->email)){
            $mail = new updateSetting($patient->user);
            Mail::to($patient->user->email)->send($mail);
        }
        //Notification de mises à jour de compte


        return response()->json(['patient'=>$patient]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function retirer(Request $request){

        $patient = Patient::find($request->get('patient_id'));
        if (!empty($request->get('souscripteurs'))){
            $souscripteur = Souscripteur::whereSlug($request->get('souscripteurs')[0])->first();
            if ($patient->souscripteur_id == $souscripteur->user_id){
                $patient->souscripteur_id = null;
                $patient->save();

                if (!is_null($patient->souscripteur)){
                    if (!is_null($patient->souscripteur->user)){
                        $mail = new updateSetting($patient->souscripteur->user);
                        Mail::to($patient->souscripteur->user->email)->send($mail);
                    }
                }
            }

//            defineAsAuthor('PatientSouscripteur',$financeur->id,'create',$patient->user_id);

        }
        if (!empty($request->get('financable_slug'))){
            $financeurSlug = $request->get('financable_slug');
            foreach ($financeurSlug  as $slug){
                $this->validatedSlug($slug,$this->table);
                $financeur = PatientSouscripteur::whereSlug($slug)->first();
                $financeur->delete();

                defineAsAuthor('PatientSouscripteur',$financeur->id,'create',$patient->user_id);

                if (!is_null($financeur->financable)){
                    if (!is_null($financeur->financable->user)){
                        $mail = new updateSetting($financeur->financable->user);
                        Mail::to($financeur->financable->user->email)->send($mail);
                    }
                }
            }
        }

        $patient = Patient::with(['souscripteur.user','user','affiliations','etablissements','financeurs.financable.user'])->restrictUser()->whereSlug($patient->slug)->first();

        //Notification de mises à jour de compte
        try{
            if (!is_null($patient->user->email)){
                $mail = new updateSetting($patient->user);
                Mail::to($patient->user->email)->send($mail);
            }

        }catch (\Swift_TransportException $transportException){
            $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
            return response()->json(['patient'=>$patient, "message"=>$message]);

        }

        return response()->json(['patient'=>$patient]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
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

        $financeur = PatientSouscripteur::whereSlug($slug)->first();
        $financeur->delete();

        return response()->json(['financeur'=>$financeur]);
    }
}
