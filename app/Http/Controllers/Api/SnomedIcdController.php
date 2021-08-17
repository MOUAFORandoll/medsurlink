<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\ToDoListRequest;
use App\Models\Snomed;
use App\Traits\DossierTrait;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;
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
        //$snomed = new Snomed();
        $client = new Client();
        $url = "https://mapping.ihtsdotools.org/mapping/record/project/id/12?ancestorId=&relationshipName=&relationshipValue=&query=".$string."&excludeDescendants=false";

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "startIndex": 0,
            "maxResults": 50,
            "sortField": null,
            "queryRestriction": ""
        }',
          CURLOPT_HTTPHEADER => array(
            'Authorization: guest',
            'Content-Type: application/json'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);

        $data = json_decode($response);
        return response()->json($data);
    }


}
