<?php /** @noinspection ALL */
/** @noinspection ALL */

/** @noinspection PhpInconsistentReturnPointsInspection */

namespace App\Http\Controllers\Api;

use App\Http\Requests\EchographieRequest;
use App\Models\Echographie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EchographieController extends Controller
{
    protected $table = "echographies";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $echographies = Echographie::with('consultation')->get();
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
        if ($request->has('error'))
        {
            return  response()->json(['error'=>$request->all()['error']],419);
        }
        $echographie = Echographie::create($request->validated());
        defineAsAuthor("Echographie",$echographie->id,'create');

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
        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;

        $echographie = Echographie::with('consultation')->whereSlug($slug)->first();
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
        if ($request->has('error'))
        {
            return  response()->json(['error'=>$request->all()['error']],419);
        }

        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;
        $echographie = Echographie::findBySlug($slug);
        $isAuthor = checkIfIsAuthorOrIsAuthorized("Echographie",$echographie->id,"create");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }

        Echographie::whereSlug($slug)->update($request->validated());
        $echographie = Echographie::with('consultation')->whereSlug($slug)->first();
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
        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;

        $echographie = Echographie::findBySlug($slug);
        $isAuthor = checkIfIsAuthorOrIsAuthorized("Echographie",$echographie->id,"create");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }

        $echographie = Echographie::with('consultation')->whereSlug($slug)->first();
        $echographie->delete();
        return response()->json(['echographie'=>$echographie]);
    }
}
