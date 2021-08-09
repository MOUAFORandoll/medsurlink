<?php
/**
 * User: me2resh
 * Date: 29/11/2018
 * Time: 01:26
 */
namespace App\Models;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Snomed
{

    /**
     * @var string
     */
    private $baseUrl = 'https://browser.ihtsdotools.org/snowstorm/snomed-ct/';

    /**
     * @var string
     */
    private $edition = 'MAIN';

    /**
     * @var string
     */
    private $version = '2019-07-31';

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * Snomed constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Find a concept by a string (e.g. "heart attack")
     * @param $searchTerm
     *
     * @return string
     */
    function getConceptByString($searchTerm)
    {
        $url = $this->baseUrl . $this->edition . '/' . $this->version . '/concepts?term=' . $searchTerm . '&activeFilter=true&offset=0&limit=50';
        $res = $this->client->get($url);

        return $res->getBody()->getContents();
    }

    /**
     * Find/get a description by a description SCTID (e.g. "679406011")
     * @param $id
     *
     * @return string
     */
    function getDescriptionById($id)
    {

        $url = $this->baseUrl . $this->edition . '/' . $this->version . '/descriptions/' . $id;
        $res = $this->client->get($url);

        return $res->getBody()->getContents();
    }

    /**
     * Find/get a concept by a concept SCTID (e.g. "109152007")
     * @param $id
     *
     * @return string
     */
    function getConceptBySCTID($id)
    {


        $url = $this->baseUrl . 'browser/' . $this->edition . '/' . $this->version . '/concepts/' . $id;
        $res = $this->client->get($url);

        return $res->getBody()->getContents();
    }

    /**
     * Find a concept by a string (e.g. "heart") but only in the Procedures semantic tag
     * @param $searchTerm
     *
     * @return string
     */
    function getConceptByStringInProceduresSemanticTag($searchTerm)
    {

        //$url = $this->baseUrl . 'browser/' . $this->edition . '/concepts?term=' . $searchTerm . '&conceptActive=true&semanticTag=procedure&groupByConcept=false&searchMode=STANDARD&offset=0&limit=50';
       // $res = $this->client->get($url);
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
        return $resp;

    }
}

