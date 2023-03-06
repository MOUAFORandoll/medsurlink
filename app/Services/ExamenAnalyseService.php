<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

use function GuzzleHttp\json_decode;

class ExamenAnalyseService
{
    use RequestService;

    /**
     * @var string
     */
    protected $baseUri;

    /**
     * @var string
     */
    protected $secret;

    public $niveau_urgence, $user_id;

    /**
     * @var string
     */
    protected $path;

    public function __construct()
    {
        $this->baseUri = config('services.teleconsultations.base_uri');
        $this->secret = config('services.teleconsultations.secret');
        $this->path = "/api/v1/examen_analyses";
        $this->niveau_urgence = new NiveauUrgenceService;
        if(\Auth::guard('api')->user()){
            $this->user_id = \Auth::guard('api')->user()->id;
        }

    }

    /**
     * @return string
     */
    public function fetchExamenAnalyses(Request $request) : string
    {
        $examen_analyses = json_decode($this->request('GET', "{$this->path}?user_id={$this->user_id}&search={$request->search}&page={$request->page}&page_size={$request->page_size}"), true);

        $items = [];
        foreach($examen_analyses['data']['data'] as $item){
            $patient = new PatientService;
            $item['patient'] = $patient->getPatient($item['patient_id'], "dossier,affiliations,user");
            $item['medecin'] = $patient->getMedecin($item['medecin_id']);
            $items[] = $item;
        }
        $examen_analyses['data']['data'] = $items;

        return json_encode($examen_analyses);
    }

    /**
     * @param $examen_analyse
     *
     * @return string
     */
    public function fetchExamenAnalyse($examen_analyse) : string
    {
        return $this->request('GET', "{$this->path}/{$examen_analyse}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createExamenAnalyse($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

    /**
     * @param $examen_analyse
     * @param $data
     *
     * @return string
     */
    public function updateExamenAnalyse($examen_analyse, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$examen_analyse}", $data);
    }

    /**
     * @param $examen_analyse
     *
     * @return string
     */
    public function deleteExamenAnalyse($examen_analyse) : string
    {
        return $this->request('DELETE', "{$this->path}/{$examen_analyse}");
    }

}
