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
        $url = "https://mapping.ihtsdotools.org/mapping/record/project/id/12?ancestorId=&relationshipName=&relationshipValue=&query=".$searchTerm."&excludeDescendants=false";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $headers = array(
           "Authorization: guest",
           "Content-Type: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        
        $data = <<<DATA
        {
            "startIndex": 0,
            "maxResults": 50,
            "sortField": null,
            "queryRestriction": ""
        }
        DATA;
        
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        $resp = curl_exec($curl);
        curl_close($curl);
       // dd($resp);

        $data = json_decode($resp);
        return response()->json($data);
    }


}
