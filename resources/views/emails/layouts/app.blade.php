<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>@yield('title')</title>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        div,
        h1,
        h2,
        h3,
        h4,
        ul,
        li,
        p {
            margin: 0;
            padding: 0;
        }

        .text-center {
            text-align: center;
        }

        .gray-color {
            color: #aaa;
        }

        .content-body,
        .content-title {
            padding: 2rem;
        }

        .content-title {
            background-image: url("{{ asset('images/emails/cover.png') }}");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            align-items: center;
        }

        .content-body {
            line-height: 3;
        }

        .content-body a {
            border: none;
            text-decoration: none;
            background-color: #2dcecc;
            padding: 1rem 2rem;
            border-radius: 5px;
            font-size: 1em;
            color: #fff;
            cursor: pointer;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }

        .content-body-text p {
            line-height: 1.5;
            margin-bottom: 8px;
        }

        .content-title .img {
            max-width: 45rem;
        }

        .content-title h1 {
            font-size: 5em;
        }

        .img img {
            width: 100%;
        }

        .social-link {
            background-color: #172b4d;
            padding: 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: .5rem;
        }

        .social-link a,
        li,
        h3 {
            color: #fff;
            text-decoration: none;
        }

        .social-link ul {
            display: flex;
            align-items: center;
            list-style: none;
            gap: 1em;
        }

        .social-media li a {
            background-color: #f5f5f5f5;
            color: #172b4d;
            height: 1.5rem;
            width: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 32px;
        }

        /*  .footer {
                position: fixed;
                left: 0;
                bottom: 0;
                width: 100%;
            } */

        .footer .adresse {
            text-align: center;
            line-height: 1.5;
            padding: 1rem;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="">
            @yield('content')
        </div>
        <div class="footer">
            <div class="social-link">
                <ul class="social-media">
                    <h3>Suivez-nous</h3>
                    <li><a href="https://be.linkedin.com/company/medicasure"><i class="fa-brands fa-linkedin-in"></i></a></li>
                    <li><a href="https://twitter.com/medicasure?lang=fr"><i class="fa-brands fa-twitter"></i></a></li>
                    <li><a href="https://www.instagram.com/medicasure/?hl=fr"><i class="fa-brands fa-instagram"></i></a></li>
                    <li><a href="https://www.facebook.com/Medicasure/?locale=fr_FR"><i class="fa-brands fa-facebook-f"></i></a></li>
                </ul>
                <ul class="link">
                    <li><a href="https://redirections-medicasure.medsurlink.com">Accueil</a></li>
                    <li>|</li>
                    <li><a href="https://redirections-medicasure.medsurlink.com/particuliers/contact">Contact</a></li>
                    <li>|</li>
                    <li><a href="https://redirections-medicasure.medsurlink.com/alertes">Alertes</a></li>
                    <li>|</li>
                    <li><a href="https://redirections-medicasure.medsurlink.com/particuliers/nos-offres">Produits</a></li>
                </ul>
            </div>
            <div class="adresse">
                <p>Tél: 0032 491 64 64 14</p>
                <p>Adresse: Rue du Castel(lrc) 18 - 7801 Ath Belgique</p>
            </div>
        </div>
    </div>
</body>

</html>