@component('mail::message')
{{$souscripteur->sexe=='M' ? 'Cher Monsieur' : 'Chere Madame'}} {{strtoupper($souscripteur->user->nom).'  '.ucfirst($souscripteur->user->prenom)}} {{$souscripteur->sexe=='M' ? 'Souscripteur' : 'Souscriptrice'}}, Bonjour

Sauf erreur ou omission de notre part, le paiement du solde de votre dette auprès de Medicasure ne nous est pas parvenu.

Nous vous prions de bien vouloir procéder à son règlement dans les meilleurs délais, et vous adressons, à toutes fins utiles, un duplicata de cette facture en pièce jointe.

Si par ailleurs votre paiement venait à nous parvenir avant la réception de ce rappel, nous vous saurions gré de ne pas tenir compte de ce dernier.

Si vous avez besoin d’éclaircissements ou si vous avez des questions, n'hésitez pas à prendre un rendez-vous avec un de nos collaborateurs via le lien https://www.medicasure.com/rendez-vous

En vous remerciant encore pour la confiance que vous nous avez accordé, et que vous nous accorderez ultérieurement, et en espérant que vous avez été satisfait du service, nous vous prions d'agréer nos salutations cordiales.

DATE LIMITE DE PAIEMENT: {{now()->addDays(7)->format('d-m-yy')}}

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
