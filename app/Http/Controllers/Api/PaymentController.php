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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Netpok\Database\Support\DeleteRestrictionException;
use Stripe\Charge;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Swap\Builder;

class PaymentController extends Controller
{
    use PersonnalErrors;
    use SmsTrait;
    protected $table = 'payments';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::with(['souscripteur','patients'])->get();
        return response()->json(['payments'=>$payments]);
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
            "method" =>"stripe",
            "statut" =>"NON PAYE",
            "slug" => $request->souscripteur_id,
            "motif" => "Paiement des prestations médicales"
        ]);
        //$url = '/payment/prestation/'.$payment->id);
        return  response()->json(['url'=>$payment]);
    }
    
    public function paymentPrestation(Request $request){

        $swap = (new Builder())
            ->add('fixer', ['access_key' => '6725eecbfab360915787d6dabfc326c9'])
            ->add('currency_layer', ['access_key' => '6725eecbfab360915787d6dabfc326c9', 'enterprise' => false])
            ->build();
        $euroFranc = $swap->latest('EUR/XAF')->getValue();
        Stripe::setApiKey('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');
        //Stripe::setApiKey('sk_test_51HfRm5AB7Hl5NGXsFgNP6YeAnDn8W4ieGbRuREW0YU1IJRIXPvlNEDYANGCStZ3KP4aGV5mWewJQevVmdPlPh5RR00FDtdo9q5');
        $payment = Payment::whereId($request->get('id'))->first();
        //dd($payment->patients->user->nom);
        $session =   Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'EUR',
                    'product_data' => [
                        'name' => 'Paiement des prestations sur '.$payment->patients->user->nom.' '.$payment->patients->user->prenom,
                    ],
                    'unit_amount' => $payment->amount*100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('https://www.medsurlink.com/payment-prestation/success/'.$request->get('id')),
            'cancel_url' => url('https://www.medsurlink.com/payment-prestation/failed/'.$request->get('id')),
        ]);
        return response()->json([ 'id' => $session->id]);
        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payments = Payment::with(['souscripteur.user','patients.user'])->whereId($id)->first();
        return response()->json(['payment'=>$payments]);
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPayment($id)
    {
        $payment = Payment::with(['souscripteur','patients'])->whereId($id)->first();
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
    public function update(PaymentUpdateRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);
    }
    public function NotifierPaiement(Request $request,$slug){

            $payment = Payment::with(['souscripteur.user','patients.user'])->whereId($slug)->first();
           // dd($payment);
            $payment->statut = 'PAYE';
            $payment->method = 'STRIPE';
            $payment->date_payment = Carbon::now()->toDateTimeString();
            $payment->save();
        return response()->json(['statut'=>$payment]);
    }
}
