<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Metrique;
use App\Models\Patient;
use App\Models\Praticien;
use App\Models\RendezVous;
use App\Models\Souscripteur;
use Illuminate\Support\Carbon;

class MetriqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rendez_vous_all = RendezVous::count();
        $rendez_vous_effectues = RendezVous::where("statut", "Effectué")->count();

        $metrique = RecuperationMetrique();
        return response()->json([
            "temps_moyen" => ConversionDesDelais($metrique->temps_moyen),
            'nbre_patients' => $metrique->nbre_patients, 
            'affiliation_et_affectation_medecin_referents' => ConversionDesDelais($metrique->affiliation_et_affectation_medecin_referents),
            'consultation_medecine_generale' => ConversionDesDelais($metrique->consultation_medecine_generale),
            'consultation_fichier' => ConversionDesDelais($metrique->consultation_fichier),
            'resultat_labo' => ConversionDesDelais($metrique->resultat_labo),
            'resultat_imagerie' => ConversionDesDelais($metrique->resultat_imagerie),
            'avis_medicals' => ConversionDesDelais($metrique->avis_medicals),
            'medecin_controle' => ConversionDesDelais($metrique->medecin_controle),
            'consultation_examen_validation' => ConversionDesDelais($metrique->consultation_examen_validation),
            'activite_amas' => ConversionDesDelais($metrique->activite_amas),
            'date_recuperation' => $metrique->date_recuperation,
            'taux_rendez_vous' => round($rendez_vous_effectues/$rendez_vous_all*100, 2)."%",
            'all_patients' => $metrique->all_patients,
            'all_souscripteurs' => $metrique->all_souscripteurs,
            'all_praticiens' => $metrique->all_praticiens
        ]);
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
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    public function courbe($date, $metrique){
        
        /**
         * Filtrage par mois
         */
        
        if($metrique == "taux_rendez_vous"){
            /**
             * diagramme de rendez-vous
             */
            $rdv_manques = RendezVous::where('statut', 'Manqué')->count();
            $rdv_annules = RendezVous::where(['statut' => 'Annulé', 'parent_id' => null])->count();
            $rdv_reprogrammes = RendezVous::where('statut', 'Annulé')->where('parent_id', '<>', null)->count();
            $rdv_effectues = RendezVous::where('statut', 'Effectué')->count();
            $rdv_programmes = RendezVous::where('statut', 'Reprogrammé')->count();
            $courbe_pie_charts = [$rdv_manques, $rdv_annules, $rdv_reprogrammes, $rdv_effectues, $rdv_programmes];

            $metriques = collect();
            for ($i = $date; $i >= 0; $i--) {
                $item = new \stdClass();
                $date = Carbon::now()->subDays($i)->format('Y-m-d');
                $item->date = $date;
                $item->manques = RendezVous::where('statut', 'Manqué')->whereDate('date', $date)->count();
                $item->annules = RendezVous::where(['statut' => 'Annulé', 'parent_id' => null])->whereDate('date', $date)->count();
                $item->reprogrammes = RendezVous::where('statut', 'Annulé')->where('parent_id', '<>', null)->whereDate('date', $date)->count();
                $item->effectues = RendezVous::where('statut', 'Effectué')->whereDate('date', $date)->count();
                $metriques->push($item);
            }
            $jours = $metriques->pluck('date');
            $manques = [
                "label" => "Rendez-vous manqués",
                "data" => $metriques->pluck('manques'),
                "borderColor" => "#3c8dbc",
                "borderWidth" => 3
            ];
            $annules = [
                "label" =>  "Rendez-vous annulés",
                "data" => $metriques->pluck('annules'),
                "borderColor" => "#f56954",
                "borderWidth" => 3
            ];
            $effectues = [
                "label" => "Rendez-vous honorés",
                "data" => $metriques->pluck('effectues'),
                "borderColor" => "#7283D4",
                "borderWidth" => 3
            ];
            $reprogrammes = [
                "label" => "Rendez-vous reprogrammés",
                "data" => $metriques->pluck('reprogrammes'),
                "borderColor" => "#f39c12",
                "borderWidth" => 3
            ];
            $data = new \stdClass();
            $data->labels = $jours;
            $data->datasets = [$manques, $annules, $effectues, $reprogrammes];

            $courbe = new \stdClass();
            $courbe->type = "line";
            $courbe->data = $data;
            $courbe->options = [
                "title" => [
                    "display" => true,
                    "text" => "Evolution des rendez-vous"
                ],
                "responsive" => true,
                "lineTension" => 1
            ];
            return response()->json(["courbe" => $courbe, "courbe_pie_charts" => $courbe_pie_charts]);
        }else{
            $today = Carbon::now()->format('Y-m-d');
            $date = Carbon::now()->subDays($date+1)->format('Y-m-d');
            $metriques = Metrique::semaineMoisAnnee($date, $today)->get();
            $metriques = $metriques->map(function ($item, $key) {
                $item = $item;
                $item->nbre_patients = $item->nbre_patients;
                $item->temps_moyen = $item->temps_moyen;
                $item->affiliation_et_affectation_medecin_referents = $item->affiliation_et_affectation_medecin_referents;
                $item->consultation_medecine_generale = $item->consultation_medecine_generale;
                $item->resultat_labo = $item->resultat_labo;
                $item->resultat_imagerie = $item->resultat_imagerie;
                $item->avis_medicals = $item->avis_medicals;
                $item->medecin_controle = $item->medecin_controle;
                $item->consultation_examen_validation = $item->consultation_examen_validation;
                $item->activite_amas = $item->activite_amas;
                $item->consultation_fichier = $item->consultation_fichier;
                $item->date = $item->created_at->format('d-m-Y');
                return $item;
            });
            $jours = $metriques->pluck('date');
            switch ($metrique) {
                case "nbre_patients":
                    $graphe = [
                        "label" =>  "Nombre de patients sur la base de calcul",
                        "data" => $metriques->pluck('nbre_patients'),
                        "borderColor" => "#36495d",
                        "borderWidth" => 3
                    ];
                    break;
                case "temps_moyen":
                    $graphe = [
                        "label" =>  "Temps moyens de prise en charge",
                        "data" => $metriques->pluck('temps_moyen'),
                        "borderColor" => "#6a1ec9",
                        "borderWidth" => 3
                    ];
                    break;
                case "affiliation_et_affectation_medecin_referents":
                    $graphe = [
                        "label" =>  "Affiliation et affectation du medécin reférent",
                        "data" => $metriques->pluck('affiliation_et_affectation_medecin_referents'),
                        "borderColor" => "#6a1ec9",
                        "borderWidth" => 3
                    ];
                    break;

                case "consultation_medecine_generale":
                    $graphe = [
                        "label" =>  "Consultation médécine générale",
                        "data" => $metriques->pluck('consultation_medecine_generale'),
                        "borderColor" => "#e83523",
                        "borderWidth" => 3
                    ];
                    break;
                case "resultat_labo":
                    $graphe = [
                        "label" =>  "Resultat de laboratoire",
                        "data" => $metriques->pluck('resultat_labo'),
                        "borderColor" => "#5c0bf3",
                        "borderWidth" => 3
                    ];
                    break;
                case "resultat_imagerie":
                    $graphe = [
                        "label" =>  "Résultat imagerie",
                        "data" => $metriques->pluck('resultat_imagerie'),
                        "borderColor" => "#1bdce6",
                        "borderWidth" => 3
                    ];
                    break;
                case "avis_medicals":
                    $graphe = [
                        "label" =>  "Avis médicaile",
                        "data" => $metriques->pluck('avis_medicals'),
                        "borderColor" => "#1bbce6",
                        "borderWidth" => 3
                    ];
                    break;
                case "medecin_controle":
                    $graphe = [
                        "label" =>  "Activité du médécin controle",
                        "data" => $metriques->pluck('medecin_controle'),
                        "borderColor" => "#1bbce6",
                        "borderWidth" => 3
                    ];
                    break;
                case "consultation_examen_validation":
                    $graphe = [
                        "label" =>  "Validation des examens",
                        "data" => $metriques->pluck('consultation_examen_validation'),
                        "borderColor" => "#1bbce6",
                        "borderWidth" => 3
                    ];
                    break;
                case "activite_amas":
                    $graphe = [
                        "label" =>  "Activité Administratives",
                        "data" => $metriques->pluck('activite_amas'),
                        "borderColor" => "#1bbce6",
                        "borderWidth" => 3
                    ];
                    break;
                case "consultation_fichier":
                    $graphe = [
                        "label" =>  "Rapport de consultation",
                        "data" => $metriques->pluck('consultation_fichier'),
                        "borderColor" => "#1bbce6",
                        "borderWidth" => 3
                    ];
                    break;
            
            }
            $data = new \stdClass();
            $data->labels = $jours;
            $data->datasets = [
                $graphe
            ];

            $courbe = new \stdClass();
            $courbe->type = "line";
            $courbe->data = $data;
            $courbe->options = [
                "title" => [
                    "display" => true,
                    "text" => $graphe["label"]
                ],
                "responsive" => true,
                "lineTension" => 1
            ];    
            
            return response()->json(["courbe" => $courbe]);
        }

        
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function nbre_users($metrique = "all_patients"){
        $data = collect();
        $cumules = collect();
        $patient = Patient::orderBy("created_at")->first();
        $date = Carbon::parse($patient->created_at);
        $titre = $metrique == "all_patients" ? "patients" : ($metrique == "all_souscripteurs" ? "souscripteurs" : "praticiens");
        $effectifCumule = 0;
        for ($j= $date->year; $j <= date('Y'); $j++) {
            if($metrique == "all_patients"){
                $result = Patient::whereYear('created_at', $j)->selectRaw('MONTH(created_at) as month, COUNT(*) as total')->groupBy('month')->orderBy('month')->get();

            }elseif($metrique == "all_souscripteurs"){
                $result = Souscripteur::whereYear('created_at', $j)->selectRaw('MONTH(created_at) as month, COUNT(*) as total')->groupBy('month')->orderBy('month')->get();
            }else{
                $result = Praticien::whereYear('created_at', $j)->selectRaw('MONTH(created_at) as month, COUNT(*) as total')->groupBy('month')->orderBy('month')->get();
            }
            // Remplir les mois sans patient
            for ($i = 0; $i < 12; $i++) {
                if(!isset($result[$i])) {
                    $item = new \stdClass();
                    $item->month = $i+1;
                    $item->total = 0;
                    $item->age = 0;
                    $result->push($item);
                }
            }

            foreach($result as $res){
                $effectifCumule += $res->total;
                $res->cumules = $effectifCumule;
            }

            /**
             * Calcul des effectifs cumulés
             */
            $result_cumules = $result->map(function($item){ return $item->cumules;});
            $annee_cumules = new \stdClass();
            $annee_cumules->label = "Evolution cumulés des {$titre} en {$j}";
            $annee_cumules->type = "line";
            $annee_cumules->data = $result_cumules;
            $annee_cumules->borderColor = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            $annee_cumules->borderWidth = 3;
            $cumules->push($annee_cumules);

            $result = $result->map(function($item){ return $item->total;});
            $annee = new \stdClass();
            $annee->label = "Evolution des {$titre} en {$j}";
            $annee->type = "line";
            $annee->data = $result;
            $annee->borderColor = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            $annee->borderWidth = 3;
            $data->push($annee);

        }
        return["data" => $data, "debut" => $date->year, "fin" => date('Y'), 'cumules' => $cumules];
    }
}
