@extends('pdf.layouts.pdf')
@section('title', 'Le titre')
@section('content')
    <div class="container-fluid">
        <header>
            <div class="img">
                <img src="{{public_path('/images/pdf/logo-white.png')}}" class="logo-rapport" alt="" />
            </div>
        </header>
        <div class="container ">
            <div class="info-user">
                <h2>Identification de tatio william</h2>
                <ul class="list-none">
                    <li class="li-top">
                        <span>
                            <span class="title">Nom: </span>
                            <span class="info">TATIO WILLIAM TCHUIFANG TATIO WILLIAM</span>
                        </span>
                        <span>
                            <span class="title">Age: </span>
                            <span class="info">25</span>
                        </span>
                    </li>
                    <li class="li-bottom">
                        <span>
                            <span class="title">Date de naissance: </span>
                            <span class="info">25/05/1995</span>
                        </span>
                        <span class="span">
                            <span class="title">Numéro de dossier: </span>
                            <span class="info">5926277</span>
                        </span>
                    </li>
                </ul>
            </div>

            <div class="content mt-2">
                <h1>Bon de prise en charge</h1>
                <div class="content-text">
                    <p>
                        Concerne <strong>Mme Terfa DOUALA</strong>, patiente née le <strong>1er janvier 2004</strong>, résidant à <strong>Mbouda – Cameroon</strong> 
                    </p>
                    <p>
                        Honorée Consœur, Honoré Confrère, bonjour <br /><br />
                        Voudriez-vous prendre contact avec la patiente sus mentionnée en vue d'une consultation de Ostéoarticulaire le <strong>4 avril 2022</strong> <br /><br />
                        Contact Patiente : <strong>237 674 315 311</strong>
                    </p>
                </div>
                <fieldset class="content-field mt-2">
                    <legend>MOTIFS PRINCIPAUX DE CONSULTATION INITIALE</legend>
                    <ul class="content-field-list list-none">
                        <li>1. Tuméfaction/gonflement loc. peau</li>
                        <li>2. Douleur abdominale</li>
                        <li>3. Prolapsus hémorrhoidaire</li>
                    </ul>
                </fieldset>
                <fieldset class="content-field mt-2">
                    <legend>Plaintes</legend>
                    <p>
                        Necessitatibus voluptas quos doloribus. Quia saepe ut vel eaque est consequatur excepturi nam.
                        Et voluptate illum quia molestiae. Est dolorem unde architecto sunt voluptas voluptatibus aut ea.
                    </p>
                </fieldset>
                <fieldset class="content-field mt-2">
                    <legend>BULLETIN D’EXAMENS / ORDONNANCES DISPONIBLES</legend>
                    <p>
                        Necessitatibus voluptas quos doloribus. Quia saepe ut vel eaque est consequatur excepturi nam.
                        Et voluptate illum quia molestiae. Est dolorem unde architecto sunt voluptas voluptatibus aut ea. 
                    </p>
                </fieldset>
            </div>
        </div>
    </div>
@endsection