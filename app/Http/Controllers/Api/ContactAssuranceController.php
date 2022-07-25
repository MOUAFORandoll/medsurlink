<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactAssurance;
use Illuminate\Http\Request;
use Netpok\Database\Support\DeleteRestrictionException;

class ContactAssuranceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contact_assurances = ContactAssurance::latest()->get();
        return response()->json(['contact_assurances' =>  $contact_assurances]);
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
    public function store(Request $request)
    {
        $contactAssurance = ContactAssurance::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'entreprise' => $request->entreprise,
            'pays' => $request->pays,
            'description' => $request->description
        ]);


        return response()->json(['contactAssurance' => $contactAssurance]);
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function show(ContactAssurance $contactAssurance)
    {
        //$contactAssurance = ContactAssurance::find();

        return response()->json(['contactAssurance' => $contactAssurance]);

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
     * @param SpecialiteRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, ContactAssurance $contactAssurance)
    {

        $contactAssurance->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'entreprise' => $request->entreprise,
            'pays' => $request->pays,
            'description' => $request->description
        ]);

        return response()->json(['contactAssurance' => $contactAssurance]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy(ContactAssurance $contactAssurance)
    {
        try{
            $contactAssurance->delete();
            return response()->json(['contactAssurance'=> "success"]);

        }catch (DeleteRestrictionException $deleteRestrictionException){
            $this->revealError('deletingError',$deleteRestrictionException->getMessage());
        }

    }
}
