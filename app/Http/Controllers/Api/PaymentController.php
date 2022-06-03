<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Models\Payment;
use App\Models\ReponseSecrete;
use App\Models\Souscripteur;
use App\Traits\SmsTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentRequest;
use App\Http\Controllers\Controller;
use App\Models\NotificationPaiement;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Netpok\Database\Support\DeleteRestrictionException;
use Stripe\Charge;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Swap\Builder;
use Ramsey\Uuid\Uuid;

class PaymentController extends Controller
{
    use PersonnalErrors;
    use SmsTrait;

    public $url_global= "";

    public function __construct()
    {
        $env = strtolower(config('app.env'));
        if ($env == 'local')
            $this->url_global = config('app.url_loccale');
        else if ($env == 'staging')
            $this->url_global = config('app.url_stagging');
        else
            $this->url_global = config('app.url_prod');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::with(['souscripteur','patients'])->latest()->get();
        $_payments = $payments->where('uuid', null)->all();
        foreach($_payments as $payment){
            $payment->uuid = Uuid::uuid4()->toString();
            $payment->save();
        }


        return response()->json(['payments' => $payments]);
    }

    public function listPaiementSouscripteur()
    {
        $payments = Payment::with(['souscripteur','patients'])->where('souscripteur_id', auth()->user()->id)->latest()->get();

        foreach($payments as $payment){
            $payment['facture'] = route('facture.paiement.prestation', $payment->uuid);
            $$payments[] = $payment;
        }

        return response()->json(['payments' => $payments]);
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
     * @param PaymentRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(PaymentRequest $request)
    {
        $request->validated();
       // dd($request->souscripteur_id);
        $payment = Payment::create([
            "patient_id" => $request->patient_id,
            "souscripteur_id" => $request->souscripteur_id,
            "amount" => $request->amount,
            "date_facturation" => $request->date_facturation,
            "method" =>"stripe",
            "statut" =>"NON PAYE",
            "slug" => $request->souscripteur_id,
            "motif" => "Paiement des prestations médicales",
            'uuid' => Uuid::uuid4()->toString()
        ]);
        //$url = '/payment/prestation/'.$payment->id);
        return  response()->json(['url'=>$payment]);
    }

    public function paymentPrestation(Request $request){

        $payment = Payment::where('uuid', $request->id)->first();
        $description = "d'actes médicaux effectués sur le patient ".$payment->patients->user->nom.' '.$payment->patients->user->prenom;
        if($request->moyenpaiement == "stripe"){
            Stripe::setApiKey(config('app.stripe_key'));

            $session =   Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'XAF',
                        'product_data' => [
                            'name' => $description
                        ],
                        'unit_amount' => $payment->amount,
                    ],
                    'quantity' =>1,
                ]],
                'mode' => 'payment',
                'success_url' => url($this->url_global.'/payment-prestation/success/'.$request->id),
                'cancel_url' => url($this->url_global.'/payment-prestation/failed/'.$request->id)
            ]);
            return response()->json(['id' => $session->id, 'moyenpaiement' => $request->moyenpaiement]);
        }
        elseif($request->moyenpaiement == "orange"){
            $access_token = getOmToken();
            $mp_token = initierPaiement($access_token);

            $body = [
                //"notifUrl" => "https://0c6d-154-72-168-215.ngrok.io/api/paiement/prestation/om/{$payment->id}/notification",
                "notifUrl" => route('prestation.om.notification', ['payment_id' => $payment->id]),
                "channelUserMsisdn"=> "658392349",
                "amount"=> $payment->amount,
                "subscriberMsisdn"=> $request->telephone,
                "pin"=> "2019",
                "orderId"=> $payment->id,
                "description"=> $description,
                "payToken"=> $mp_token
            ];

            $reponse = procederAuPaiementOm($access_token,$body);
            return response()->json(['reponse' => $reponse, 'moyenpaiement' => $request->moyenpaiement]);
        }

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payments = Payment::with(['souscripteur.user','patients.user'])->whereUuid($id)->first();
        return response()->json(['payment'=>$payments]);
    }

    /**
     * OM Notification
     */
    public function notificationPaiement(Request $request, $payment_id){

        $notif = NotificationPaiement::create([
            "type" =>'OM',
            "code_contrat" => $payment_id,
            "pay_token" => $request->payToken,
            "statut" => $request->status,
            "reponse" => json_encode($request->all())
        ]);
    }

    /**
     * Status de paiement par OM
     */
    public function statutPaiement($pay_token){

        $notification = NotificationPaiement::where('pay_token', $pay_token)->first();

        //{"payToken":"MP2202244469409A5830F5160CF1","status":"SUCCESSFULL","message":"Transaction completed"}
        $payment = Payment::find($notification->code_contrat);

        if($notification->statut == "SUCCESSFULL"){
            $payment->statut = "PAYE";
            $payment->method = 'OM';
            $payment->date_payment = Carbon::now()->toDateTimeString();
            $this->EnvoiDesEmails($payment);


        }elseif($notification->statut == "FAILED" || $notification->statut == 'PENDING' || $notification->statut == 'CANCELLED'){
            $payment->statut = "NON PAYE";
        }
        $payment->save();

        return response()->json($notification);
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPayment($id)
    {
        $payment = Payment::whereUuid($id)->first();
        return response()->json(['payment'=>$payment]);
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
     * @param PaymentUpdateRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $payment =  Payment::whereUuid($id)->first();
        $payment->patient_id = $request->patient_id;
        $payment->souscripteur_id = $request->souscripteur_id;
        $payment->amount = $request->amount;
        $payment->save();

        return response()->json(['payment'=>$payment]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($id)
    {
        $payments = Payment::with(['souscripteur.user','patients.user'])->whereUuid($id)->first();
        $payments->delete();
        return response()->json(['payment'=>$payments]);
    }
    public function NotifierPaiement(Request $request,$slug){

            $payment = Payment::with(['souscripteur.user','patients.user'])->whereId($slug)->first();
           // dd($payment);
            $payment->statut = 'PAYE';
            $payment->method = 'stripe';
            $payment->date_payment = Carbon::now()->toDateTimeString();
            $payment->save();
            $this->EnvoiDesEmails($payment);
        return response()->json(['statut'=>$payment]);
    }

    public function EnvoiDesEmails(Payment $payment){
        /**
         * envoi du reçu après de paiement de la prestation
         */
        $commande_date = $payment->date_payment;
        $montant_total = $payment->amount;
        $echeance =  "13/02/2022";
        $description = $payment->motif;
        $mode_paiement = mb_strtoupper($payment->method) == 'OM' ? 'Orange Money' : 'Stripe' ;
        $prix_unitaire = 2;
        $nom_souscripteur = mb_strtoupper($payment->souscripteur->user->nom).' '.$payment->souscripteur->user->prenom;
        $email_souscripteur = $payment->souscripteur->user->email;
        $rue =  $payment->souscripteur->user->quartier;
        $adresse =  $payment->souscripteur->user->adresse;
        $pays =  $payment->souscripteur->user->pays;
        $ville = $payment->souscripteur->user->code_postal.' - '.$payment->souscripteur->user->ville;
        $beneficiaire = mb_strtoupper($payment->patients->user->nom).' '.$payment->patients->user->prenom;
        EnvoieDeFactureApresPaiementPrestation($payment->id, $commande_date, $montant_total, $echeance, $description, $mode_paiement, $nom_souscripteur, $email_souscripteur, $rue, $adresse, $ville, $pays, $beneficiaire);
    }
}
