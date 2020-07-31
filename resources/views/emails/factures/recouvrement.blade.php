@component('mail::message')
{{$souscripteur->sexe=='M' ? 'Cher Monsieur' : 'Chere Madame'}} {{strtoupper($souscripteur->user->nom).'  '.ucfirst($souscripteur->user->prenom)}} {{$souscripteur->sexe=='M' ? 'Souscripteur' : 'Souscriptrice'}}, Bonjour

Veuillez trouver votre état financier auprès de la comptabilité de Medicasure. Le montant que vous nous devez est de: {{$facture->total_avec_remise}} FCFA

Si vous avez besoin d’éclaircissements ou si vous avez des questions, n'hésitez pas à prendre un rendez-vous avec un de nos collaborateurs via le lien https://www.medicasure.com/rendez-vous

Vous pouvez consulter à tout moment les informations médicales via le lien www.medsurlink.com/login

En vous remerciant encore pour la confiance que vous nous avez accordé, et que vous nous accorderez ultérieurement, et en espérant que vous avez été satisfait du service, nous vous prions d'agréer nos salutations cordiales.

DATE LIMITE DE PAIEMENT: {{now()->addDays(10)->format('d-m-yy')}}


COMPTABILITÉ

Tel:+4917643171205
+237674411042
comptabilite@medicasure.com

Intermédiation médicale

Rue du Castel 18, 7801 Ath Belgique
Face Lycée de Ndogpassi Douala Cameroun
www.medicasure.com

<div class="div-logo-mail">
<img class="logo-footer" src="{{asset('/images/logo.png')}}" alt="Logo-Medicasure">
</div>
@endcomponent
