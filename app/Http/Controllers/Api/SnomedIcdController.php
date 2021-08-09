<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\ToDoListRequest;
use App\Models\Snomed;
use App\Traits\DossierTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SnomedIcdController extends Controller
{
    use PersonnalErrors;
    use DossierTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //return  Snomed::getConceptByStringInProceduresSemanticTag('heart');
      return response()->json(['map'=>Snomed::getConceptByStringInProceduresSemanticTag('heart')]);
    }
    /**
     * Find a  resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function find($string)
    {
        $snomed = new Snomed();

        //Find a concept by a string (e.g. "heart attack")
        //echo $snomed->getConceptByString('Heart Attack');
        
        //Find/get a description by a description SCTID (e.g. "679406011")
        //echo $snomed->getDescriptionById('679406011');
        
        //Find/get a concept by a concept SCTID (e.g. "109152007")
        //echo $snomed->getConceptBySCTID('109152007');
        
        //Find a concept by a string (e.g. "heart") but only in the Procedures semantic tag
        $data = $snomed->getConceptByStringInProceduresSemanticTag($string);
        $data = json_decode($data);
        return response()->json($data);
    }


}
