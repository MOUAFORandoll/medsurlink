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
        $echographie = Echographie::create($request->validated());
        return response()->json(['echographie'=>$echographie]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $validation = validatedId($id,$this->table);
        if(!is_null($validation))
            return $validation;

        $echographie = Echographie::with('consultation')->find($id);
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
    public function update(EchographieRequest $request, $id)
    {
        $validation = validatedId($id,$this->table);
        if(!is_null($validation))
            return $validation;
        Echographie::whereId($id)->update($request->validated());
        $echographie = Echographie::with('consultation')->find($id);
        return response()->json(['echographie'=>$echographie]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $validation = validatedId($id,$this->table);
        if(!is_null($validation))
            return $validation;
        $echographie = Echographie::with('consultation')->find($id);
        Echographie::destroy($id);
        return response()->json(['echographie'=>$echographie]);
    }
}
