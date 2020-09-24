<p>Recevez le rapport d'hospitalisation de votre patient(e)  Mr/Mme <strong>{{$patient->user->nom}}</strong>
né(e) le <strong>{{\Carbon\Carbon::parse($patient->date_de_naissance)->format('d/m/Y')}}</strong>
qui a été pris(e) en charge par Medicasure en hospitalisation du <strong>
{{\Carbon\Carbon::parse($date_entree)->format('d/m/Y')}}</strong> {{ !is_null($date_sortie) ?'au':""}}
<strong>{{ !is_null($date_sortie) ? \Carbon\Carbon::parse($patient->date_de_naissance)->format('d/m/Y') :""}}</strong>
pour <strong>{!!  $diagnostic !!}</strong> au <strong>{{$nomEtablissement}}</strong>.
