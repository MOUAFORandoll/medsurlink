<p>Recevez la facture de votre patient(e)  Mr/Mme <strong>{{$patient->user->nom}}</strong>
    né(e) le <strong>{{\Carbon\Carbon::parse($patient->date_de_naissance)->format('d/m/Y')}}</strong>
    qui a été pris(e) en charge par Medicasure
</p>
