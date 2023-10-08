@component('mail::message')
{{$souscripteur->sexe=='M' ? 'Cher Monsieur' : 'Chere Madame'}} {{strtoupper($souscripteur->user->nom).' '.ucfirst($souscripteur->user->prenom)}} , Bonjour

Sauf erreur ou omission de notre part, le paiement du solde de votre dette auprès de Medicasure ne nous est pas parvenu.

Nous vous prions de bien vouloir procéder à son règlement dans les meilleurs délais, et vous adressons, à toutes fins utiles, un duplicata de cette facture en pièce jointe.

Si par ailleurs votre paiement venait à nous parvenir avant la réception de ce rappel, nous vous saurions gré de ne pas tenir compte de ce dernier.

Si vous avez besoin d’éclaircissements ou si vous avez des questions, n'hésitez pas à prendre un rendez-vous avec un de nos collaborateurs via le lien https://redirections-medicasure.medsurlink.com/rendez-vous

En vous remerciant encore pour la confiance que vous nous avez accordé, et que vous nous accorderez ultérieurement, et en espérant que vous avez été satisfait du service, nous vous prions d'agréer nos salutations cordiales.

DATE LIMITE DE PAIEMENT: <span style="color:red">{{now()->addDays(7)->format('d-m-yy')}}</span>

___COMPTABILITÉ___

___Tel:+4917643171205___<br>
___+237674411042___<br>
___comptabilite@medicasure.com___<br>

___INTERMÉDIATION MÉDICALE___

___Rue du Castel 18, 7801 Ath Belgique___<br>
___Face Lycée de Ndogpassi Douala Cameroun___<br>
___https://redirections-medicasure.medsurlink.com___<br>
<div class="div-logo-mail">
    <img class="logo-footer" src="https://www.back.medsurlink.com/images/logo.png" alt="Logo-Medicasure">
</div>
@endcomponent