<p>Honorée Consoeur, Honorée Confrère,</p>
<p>J'ai vu en date du <strong>{{\Carbon\Carbon::parse($date_consultation)->format('d/m/Y')}}</strong>, pour une consultation de<b> {{type_consultation}}</b>, votre patient(e)
    <strong>{{$patient->user->nom}}</strong> né(e) le <strong>{{\Carbon\Carbon::parse($patient->date_de_naissance)->format('d/m/Y')}}</strong>
    pour: @component('presentationMotifs',['motifs'=>$motifs]) @endcomponent
</p>
