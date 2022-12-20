<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{{ $title }}</title>
	<style>
		@page {
            margin: 0px 0px 0px 0px;
            padding: 0px 0px 0px 0px;
        }
		@font-face {
			font-family: 'Montserrat';
			font-style: normal;
			font-weight: 14 px;
			src: local('Montserrat-Regular'), url(http://fonts.gstatic.com/s/montserrat/v6/zhcz-_WihjSQC0oHJ9TCYC3USBnSvpkopQaUR-2r7iU.ttf) format('truetype');
		}

		@font-face {
			font-family: 'Montserrat';
			font-style: bold;
			src: local('Montserrat-Bold'), url(http://fonts.gstatic.com/s/montserrat/v6/IQHow_FEYlDC4Gzy_m8fcvEr6Hm6RMS0v1dtXsGir4g.ttf) format('truetype');
		}
		footer{
			position: fixed; 
			bottom: 78px; 
			left: 0px; 
			right: 0px;
			height: 50px; 
      	}
		.container{
			margin: 20px 70px 20px 70px;
		}
		.text-center{
			text-align: center;
			padding: 0px 0px 0px 0px;
			margin: 0px 0px 0px 0px;
		}
		.underline{
			text-decoration: underline;
			font-family: 'Montserrat';
		}
		.text-justify{
			text-align: justify;
			padding: 0px 0px 0px 0px;
			margin: 15px 0px 0px 0px;
			font-size: 0.85em;
		}
		.note{
			border-style: solid;
			border-width: 1px;
			padding: 15px 15px 15px 15px;
			margin-top: 30px;
			font-size: 0.7em;
			font-family: 'Montserrat';
		}
		.content{
			margin-top: 30px;
			font-family: 'Montserrat';
		}
		.bold{
			font-weight: bold;
		}
		.text-right{
			text-align: right
		}
		.float-left{
			font-size: 0.85em;
			float: left;
		}
		.float-right{
			font-size: 0.85em;
			float: right;
		}
		.right{
			position: absolute;
			left: 320px;
		}
		.left{
			position: absolute;
			left: -40px;
		}
	</style>
</head>
<body>
	<header>
		<img src="images/header.png" alt="" style="width: 100%">
	</header>
	<div class="container">
		<h2 class="text-center underline">{{ $title }}</h2>
		<div class="note">
			<p class="text-center">
				Note d’information pour le patient concernant la consultation de son dossier medical par- et le partages de ses données médicales personnelles avec- les professionnels de soins du réseau <span class="bold">Medicasure</span> et ses partenaires ainsi que son garant/souscripteur (qui financerait ses soins).
			</p>
		</div>
		<div class="content">
			<p class="text-justify">
				Madame, <br>
				Monsieur
			</p>
			<p class="text-justify">
				Vous allez pouvoir être pris en charge par un prestataire de soins faisant partie ou Non du réseau <span class="bold">Medicasure</span> à l’issue de la convention d’affiliation médicale signée entre le souscripteur (votre proche) et <span class="bold">Medicasure</span>. 
			</p>
			<p class="text-justify">
				Cette convention est centrée sur votre état de santé et nécessite donc de la part des différentes entités impliquées, d’avoir accès à vos données personnelles d’ordre médical pour une meilleure prise en charge. Ces données (rapport médical, résultats d’examens, coûts des prestations entre autres) doivent permettre aux prestataires de soins et à <span class="bold">Medicasure</span> d’établir un meilleur parcours de soins qui corresponde à vos attentes. 
			</p>
			<p class="text-justify">
				En signant ce consentement, vous autorisez <span class="bold">Medicasure</span> à accéder à vos informations de santé et à collaborer avec les différentes entités qui participent à votre suivi médical dans le but d’optimiser votre prise en charge. 
			</p>
			<p class="text-justify content">
				@php
					\Carbon\Carbon::setLocale('fr');
					$date = \Carbon\Carbon::now();
				@endphp
				Fait le {{ $date->translatedFormat('l jS F Y') }}
			</p>
			<p>
				<span class="float-left">Le Patient / Représentant</span>
				<span class="float-right">Le Souscripteur / Représentant
					({{ $lien }})
				</span>
			</p><br>
			<p>
				<span class="float-left bold">{{ ucfirst($patient->prenom) }} {{ mb_strtoupper($patient->nom) }}</span>
				<span class="float-right bold">{{ ucfirst($souscripteur->prenom) }} {{ mb_strtoupper($souscripteur->nom) }}</span>
			</p><br>
			<p>
				<span class="float-left">
					@if(!is_null($patient->signature) && $patient_consentement)
						<img src="{{ public_path(parse_url($patient->signature)['path']) }}" alt="" width="275px" class="left">
					@endif
				</span>
				<span class="float-right">
					@if(!is_null($souscripteur->signature))
						<img src="{{ public_path(parse_url($souscripteur->signature)['path']) }}" alt="" width="275px" class="right">
					@endif
				</span>
			</p>
		</div>
	</div>
	<footer>
		<img src="images/footer.png" alt="" style="width: 100%">
	</footer>
</body>
</html>