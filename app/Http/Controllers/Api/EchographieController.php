<?php /** @noinspection ALL */
/** @noinspection ALL */

/** @noinspection PhpInconsistentReturnPointsInspection */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\EchographieRequest;
use App\Models\Echographie;
use App\Traits\DossierTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EchographieController extends Controller
{
    use PersonnalErrors;
    use DossierTrait;

    protected $table = "echographies";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $echographies = Echographie::with('consultation')->get();

        foreach ($echographies as $echography){
            $echography->updateEchographie();
        }

        return response()->json(['echographies'=>$echographies]);
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
    public function store(EchographieRequest $request)
    {

        $echographie = Echographie::create($request->validated());
        $this->updateDossierId($echographie->consultation->dossier->id);

        defineAsAuthor("Echographie",$echographie->id,'create',$echographie->consultation->dossier->patient->user_id);

        return response()->json(['echographie'=>$echographie]);
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

        $echographie = Echographie::with('consultation')->whereSlug($slug)->first();

        $echographie->updateEchographie();

        return response()->json(['echographie'=>$echographie]);
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
    public function update(EchographieRequest $request, $slug)
    {


        $this->validatedSlug($slug,$this->table);

        $echographie = Echographie::findBySlug($slug);

        $this->checkIfAuthorized("Echographie",$echographie->id,"create");

        Echographie::whereSlug($slug)->update($request->validated());

        $echographie = Echographie::with('consultation')->whereSlug($slug)->first();
        $this->updateDossierId($echographie->consultation->dossier->id);
        return response()->json(['echographie'=>$echographie]);
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

        $echographie = Echographie::findBySlug($slug);

        $this->checkIfAuthorized("Echographie",$echographie->id,"create");

        $echographie = Echographie::with('consultation')->whereSlug($slug)->first();
        $this->updateDossierId($echographie->consultation->dossier->id);
        $echographie->delete();

        return response()->json(['echographie'=>$echographie]);
    }
}
