<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\OrdonanceRequest;
use App\Models\DossierMedical;
use App\Models\Ordonance;
use App\Models\OrdonanceMedicament;
use App\Models\Posologie;
use App\Models\Prescription;
use App\Traits\SmsTrait;
use Carbon\Carbon;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class OrdonanceController extends Controller
{
    protected $table = 'ordonances';
    use SmsTrait;

    use PersonnalErrors;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ordonances =  Ordonance::with('dossier','medicaments')->get();
        return response()->json(['ordonances'=>$ordonances]);
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
    public function store(OrdonanceRequest $request)
    {
        $dossier = DossierMedical::findBySlug($request->get('dossier_medical_id'));
        //creation de l'ordonnance
        $ordonance = Ordonance::create([
            'date_prescription'=> $request->get('date_prescription'),
            'dossier_medical_id'=>$dossier->id,
            'praticien_id'=>Auth::id()
        ]);
        defineAsAuthor('Ordonance',$ordonance->id,'create');

        //recuperation des prescriptions
        $prescriptions = $request->get('prescription');

        foreach ($prescriptions as $item){
            $pArray = Arr::except($item,'posologie');
            //Creation de la prescription
            $prescription = Prescription::create($pArray + ['ordonance_id'=>$ordonance->id]);
            //Création de la posologie
            $posologie = Posologie::create($item['posologie'] + ['prescription_id'=>$prescription->id]);
        }

        $ordonance =  Ordonance::with('dossier','prescriptions.medicament')->whereSlug($ordonance->slug)->first();
        return response()->json(['ordonance'=>$ordonance]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);
        $ordonance = Ordonance::with('dossier','medicaments')->whereSlug($slug)->first();
        $ordonance->updateOrdonance();
        return response()->json(['ordonance'=>$ordonance]);
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
    public function update(OrdonanceRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);
        $ordonance = Ordonance::with('dossier')->whereSlug($slug)->first();

        $this->checkIfAuthorized('Ordonance',$ordonance->id,'create');
        $ordonance->date_prescription = $request->get('date_prescription');

        $ancienMedicaments = [];
        foreach ($ordonance->medicaments as $medicament) {
            array_push($ancienMedicaments,$medicament->id);
        }
        $nouveauMedicaments = $request->get('medicaments');

        //Liste des medicaments qui ont étiré de la liste des anciens mediacament
        $medicaments = array_diff($ancienMedicaments,$nouveauMedicaments);
        if (!empty($medicaments)){
            $ordonance->medicaments()->detach($medicaments);
            foreach ($medicaments as $medicament){
                defineAsAuthor('Ordonance',$ordonance->id,'detach medicament '.$medicament,$ordonance->dossier->patient_id);
            }

        }
        //Liste des medicaments qui ont été ajouté à la liste des médicament
        $medicaments = array_diff($nouveauMedicaments,$ancienMedicaments);
        if (!empty($medicaments)){
            $ordonance->medicaments()->attach($medicaments);
            foreach ($medicaments as $medicament){
                defineAsAuthor('Ordonance',$ordonance->id,'add medicament '.$medicament);
            }
        }

        $ordonance = Ordonance::with('dossier','medicaments')->whereSlug($slug)->first();
        return response()->json(['ordonance'=>$ordonance]);
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
        $ordonance = Ordonance::with('dossier','medicaments')->whereSlug($slug)->first();

        $this->checkIfAuthorized('Ordonance',$ordonance->id,'create');

        $ordonance->delete();
        defineAsAuthor('Ordonance',$ordonance->id,'delete',$ordonance->dossier->patient_id);
        return response()->json(['ordonance'=>$ordonance]);
    }

    public function archiver($slug){
        $this->validatedSlug($slug,$this->table);
        $ordonance = Ordonance::with('dossier','medicaments')->whereSlug($slug)->first();
        if (is_null($ordonance->passed_at)){
            $this->revealNonTransmis();
        }
        $ordonance->archieved_at = Carbon::now();
        $ordonance->save();
        defineAsAuthor('Ordonance',$ordonance->id,'archieve',$ordonance->dossier->patient_id);
        //Envoi du sms
//        $this->sendSmsToUser($ordonance->dossier->patient->user);
        informedPatientAndSouscripteurs($ordonance->dossier->patient,1);

        return response()->json(['ordonance'=>$ordonance]);
    }

    public function transmettre($slug){
        $this->validatedSlug($slug,$this->table);
        $ordonance = Ordonance::with('dossier','medicaments')->whereSlug($slug)->first();

        $this->checkIfAuthorized('Ordonance',$ordonance->id,'create');

        $ordonance->passed = Carbon::now();
        $ordonance->save();

        defineAsAuthor('Ordonance',$ordonance->id,'transmettre',$ordonance->dossier->patient_id);
//Envoi du sms
        $this->sendSmsToUser($ordonance->dossier->patient->user);
        informedPatientAndSouscripteurs($ordonance->dossier->patient,0);

        return response()->json(['ordonance'=>$ordonance]);
    }
}
