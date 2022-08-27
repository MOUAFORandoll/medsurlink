<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\AntecedentRequest;
use App\Models\Antecedent;
use App\Models\DossierMedical;
use App\Traits\DossierTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class AntecedentController extends Controller
{
    use PersonnalErrors;
    use DossierTrait;
    protected $table = "antecedents";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dossier_medical_slug = $request->dossier_slug;
        $antecedents = Antecedent::whereHas('dossier', function($query) use($dossier_medical_slug) {
            $query->where('slug', $dossier_medical_slug);
        })->latest()->get();

        return response()->json(['antecedents' => $antecedents]);
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
        $this->validate($request, [
            "dossier_slug"=>"required|exists:dossier_medicals,slug",
            "description"=>"required|string|min:3",
            "date"=>"sometimes|nullable|date|before_or_equal:".Carbon::now()->format('Y-m-d'),
            "type"=>"required|string|min:2"
        ]);

        $dossier = DossierMedical::whereSlug($request->dossier_slug)->first();
        $antecedent = Antecedent::create(["dossier_medical_id" => $dossier->id, "description" => $request->description, "date" => $request->date, "type" => $request->type]);

        return response()->json(['antecedent' => $antecedent]);
    }


    /**
     * @param $slug
     * @return \Illuminate\Http\JsonResponse|null
     * @throws \Illuminate\Validation\ValidationException
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $antecedent = Antecedent::whereSlug($slug)->first();

        return response()->json(['antecedent' => $antecedent]);

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
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Http\JsonResponse|null
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $slug)
    {
        $this->validate($request, [
            "dossier_slug"=>"required|exists:dossier_medicals,slug",
            "description"=>"required|string|min:3",
            "date"=>"sometimes|nullable|date|before_or_equal:".Carbon::now()->format('Y-m-d'),
            "type"=>"required|string|min:2"
        ]);
        $this->validatedSlug($slug,$this->table);

        $antecedent = Antecedent::whereSlug($slug)->first();

        $dossier = DossierMedical::whereSlug($request->dossier_slug)->first();

        Antecedent::whereSlug($slug)->update(["dossier_medical_id" => $dossier->id, "description" => $request->description, "date" => $request->date, "type" => $request->type]);

        $antecedent = $antecedent->fresh();

        return response()->json(['antecedent' => $antecedent]);
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

        $antecedent = Antecedent::whereSlug($slug)->first();
        $antecedent->delete();

        return response()->json(['antecedent' => $slug]);
    }
}
