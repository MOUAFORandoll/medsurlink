<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ $description }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style type="text/css">
        body {
            font-family: Montserrat !important;
        }

        .cls_002 {
            color: #404040;
            font-weight: 900;
            font-family: Montserrat !important;
        }

        span.cls_003 {
            font-size: 14px;
            color: #00ada7;
            font-weight: normal;

            text-decoration: none
        }

        div.cls_003 {
            font-size: 14px;
            color: #00ada7;
            font-weight: normal;
            text-decoration: none
        }

        span.cls_006 {
            font-size: 14px;
            color: #fff;
            font-weight: normal;
            text-decoration: none
        }

        div.cls_006 {
            background-color: #00ada7;
            font-size: 13px;
            color: #fff;
            font-weight: normal;
            text-decoration: none
        }

        span.cls_004 {
            font-size: 13px;
            color: #404040;
            font-weight: normal;
            text-decoration: none
        }

        div.cls_004 {
            font-size: 13px;
            color: #404040;
            font-weight: normal;
            text-decoration: none
        }

        span.cls_005 {
            font-size: 13px;
            color: #404040;
            font-weight: bold;

            text-decoration: none
        }

        div.cls_005 {
            font-size: 13px;
            color: #404040;
            font-weight: bold;

            text-decoration: none
        }

        span.cls_007 {
            font-size: 17.3px;
            color: #fff;
            font-weight: bold;

            text-decoration: none
        }

        div.cls_007 {
            font-size: 17.3px;
            color: #fff;
            font-weight: bold;

            text-align: center;
        }

        span.cls_008 {
            font-size: 19.6px;
            color: #fff;
            font-weight: bold;

            text-align: center;
        }

        div.cls_008 {
            font-size: 19.6px;
            color: #fff;
            font-weight: bold;

            text-align: center;
        }

        span.cls_009 {
            color: #fff;
            background-color: #00ada7;
            font-size: 13px;
            font-weight: bold;

            text-decoration: none;
            width: 100%;
        }

        div.cls_009 {
            font-size: 13px;
            color: #fff;
            background-color: #00ada7;
            font-weight: bold;

            text-decoration: none;
            width: 100%;
        }

        span.cls_010 {
            font-size: 13px;
            color: #404040;
            font-weight: normal;
            text-decoration: none
        }

        div.cls_010 {
            font-size: 13px;
            color: #404040;
            font-weight: normal;
            text-decoration: none
        }

        span.cls_011 {
            text-align: center;
            font-size: 13px;
            color: #fff;
            background-color: #00ada7;
            font-weight: bold;

            text-decoration: none
        }

        div.cls_011 {
            background-color: #00ada7;
            text-align: center;
            font-size: 13px;
            color: #fff;
            font-weight: bold;

            text-decoration: none
        }

        span.cls_012 {
            font-size: 28.5px;
            color: rgb(250, 250, 250);
            font-weight: bold;

        }

        div.cls_012 {
            font-size: 28.5px;
            color: rgb(250, 250, 250);
            font-weight: bold;

            text-align: center;
        }

        span.cls_014 {
            font-size: 13px;
            color: #404040;
            font-weight: bold;

            text-decoration: none
        }

        div.cls_014 {
            font-size: 13px;
            color: #404040;
            font-weight: bold;

            text-decoration: none
        }

        span.cls_015 {
            font-size: 13px;
            color: rgb(128, 128, 128);
            font-weight: normal;
            text-decoration: none
        }

        div.cls_015 {
            font-size: 13px;
            color: rgb(128, 128, 128);
            font-weight: normal;
            text-decoration: none
        }

        .justify {
            text-align: justify;
            font-family: Montserrat;
        }

        .center {
            text-align: center;
            font-family: Montserrat;
        }

        thead {
            background-color: #00ada7;
            font-size: 13px;
            color: #fff;
            font-weight: bold;

            font-family: Montserrat;
        }

        table,
        tr,
        th {
            border: none;
            border-spacing: 0px;
            padding: 0;
            font-family: Montserrat;
        }

        tfoot tr td {
            padding-top: 20px;
            font-size: 13px;
            color: #404040;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div style="position:absolute;">
        <div style="position:absolute;left:20px;top:0px">
            <img src="{{ public_path('images/logo-medicasure.png') }}" width=300>
        </div>

        <div style="position:absolute;left:500px;top:0px" class="cls_003"><span class="cls_003">+32 491 64 64 14</span></div>
        <div style="position:absolute;left:500px;top:20px" class="cls_003"><span class="cls_003">contact@medicasure.com</span></div>
        <div style="position:absolute;left:500px;top:40px" class="cls_003"><span class="cls_003">redirections-medicasure.medsurlink.com</span></div>

        <div style="position:absolute;left:20px;top:137.25px" class="cls_002"><span class="cls_002">BILAN GLOBALE FINANCIER</span></div>
        @php
        Carbon\Carbon::setLocale('fr');
        @endphp
        <div style="position:absolute;left:20px;top:157.50px" class="cls_004"><span class="cls_004">au {{ Carbon\Carbon::now()->translatedFormat('l jS F Y') }} </span></div>
        {{-- <div style="position:absolute;left:20px;top:178.50px" class="cls_004"><span class="cls_004">du  $commande_date </span></div> --}}

        <div style="position:absolute;left:20px;top:206.25px;width: 25%; height: 93px; border:1px solid #00ada7; background-color: #00ada7;">
            <div style="position:relative; width: 100%" class="cls_011"><span class="cls_011">Total valider</span></div>
            <div style="position:relative:left: 10px; top:15px; " class="cls_007"><span class="cls_007"> {{ number_format($total_medecin_assureur, 0, '', ' ') }} XAF</span></div>
        </div>



        <div style="position:absolute;left:270px;top:150px;width: 61%; height: 150px; border:1px solid #00ada7;">
            <div style="position:relative; width: 100%" class="cls_011">&nbsp;&nbsp;<span class="cls_011">Adressé à</span></div>
            <div style="position: relative;left: 10px;top:2px" class="cls_004"><span class="cls_004"> $nom_souscripteur </span></div>
            <div style="position: relative;left: 10px;top:2px" class="cls_004"><span class="cls_004"> $rue </span></div>
            {{-- <div style="position: relative;left: 10px;top:2px" class="cls_004"><span class="cls_004"> $adresse </span></div>
            <div style="position: relative;left: 10px;top:2px" class="cls_004"><span class="cls_004"> $ville </span></div>
            <div style="position: relative;left: 10px;top:2px" class="cls_004"><span class="cls_004"> $pays </span></div> --}}
            <div style="position: relative;left: 10px;top:2px" class="cls_004"><span class="cls_004">Bénéficiaire : fdklf</span></div>
        </div>
        <div style="position:absolute;left:20px;top:306.00px; width: 100%; text-align: justify;">
            <br>
            {{-- <div class="cls_004"><span class="cls_004">Mode de Paiement: fdkllmdf</span></div><br> --}}
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th class="">Examens Complémentaire</th>
                        <th class="center">Prix</th>
                        <th class="center">Medicasure</th>
                        <th class="center">Souscripteur</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($examen_validations as $item)
                    <tr class="produit">
                        <td>{{ $item->examen }} </td>
                        <td class="center">{{ number_format($item->prix, 0, '', ' ') }}</td>
                        <td class="center">
                            @if($item->etat_validation_medecin == 1)
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAABmJLR0QA/wD/AP+gvaeTAAADfklEQVRoge2YTWgUZxjHf+9MY5pao7bYpoeWilRRmwpC/UDxI4XGQhXjrOtuQorBIraBXnoQBHGLXoUepPXjYJvGnWS6u7IKsYqKSvw46cGTtYonDSp+BZIQd/bpIdbo7uzuu7upG2F+x3n+7/P8/7vDzPsO+Pj4+Pj4+FQOVWkDnsSic1HsRtQ1+oe20tY2lEs6/gI4znRM9zzwwbMrl5ggq1ndfN9Lbrw6Zxo4zjTeSB1j1DzAIp5yFsf5yGvJ+AnQ2VmL6f6FqFlZNVFzMN1eYtG5maXxEaCnp5oa8zAwP4/qQ5Q6ishLt33lA0QiBoOP/wAaNNQ1mRcqH6B+1h5gvYZyGIxWlJIXL1Y2QNyOAN9pKNPAN1gbTmYWKhcgYW8BduiJ5UescLdXpXAAx3mbjo6JxXgrSNwOIOzRVO/Cav45VzF/gES0AdPt462q28Sia4vxmLcndAJmQa1wACu8PZ8kdwDHmY6obmAiilqUSjy7Z0snFv0MMeJAtYb6CO/WfV9I5L2VSCYnkRq4AHzqUd3PO3XtrFyZ0jAxyuGuGaSlF6jTUJ/lydCqfHug/8j+ByIRg9RAJ97mATbzoO8oyeQkDSMjJDreIy3H0DEv6irV6SYd8+AVoH7mD8CaAutWkRo4RTL6fsEJjjMZqToBfKLh5ybqaSNftzzU0AJeAZSq11z7OSl1iUTX7JyKgwffxHSTwDyNfndxzUas1jua8wHPAOwEbmiu/xiR8/xpr8iqOI5JbY0NLC/cRvpBfUUw+I/m3OdkB2gK38I1F4Cc0+wxFYPjxO3WUT+iMNN7QXQevcOkjQBW6LLmvJfwfowGgw+omfIlyCHNPhOA34nbEUQUia5dIN9qrEsj0sr60Aldw5nkP5E9N8O2InpeBBbrSaUdq/mXInpnoXekjNsbgX2M/NJjxU9Y4fJejBRzJk5EG0beojKl3KGg9mGFtpTfp5jd6Lrm04i7ALhe1kQhiWu0l9XjBYrbTgdarqOGFwO9JU1TnKF/KEQw6Ja03rNlKfT0VDP46DdQIe01oq5iDi6jqe1RSTNzUPp3oZEn1A70DiU3cc0lBIN9Jc/LQfkftuL2JuBXoCqH4h5KLWVd6O+yZ3kwNl/mYocawXBQ1GZUHiJ8QSB8ZUzmeDA2Z+JAy3FMNR/oBu4iPAEVR9IL/0/zPj4+Pj4+rz3/AtUy/TZ0ya9hAAAAAElFTkSuQmCC" style="width: 25px;">
                            @else
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAABmJLR0QA/wD/AP+gvaeTAAAEi0lEQVRoge2ZTU8bVxSG33NpU5WCKCUTY4TUWBDCh+hiZmE2LMKCOwKFIqxIbQqb/ICA2k35B+2qVf9D1aZVUkWVgqgrpQsWYVEWVIaqRsIIRIlg4YliyxH4nC74ECB7fMdjFpX8Sl5Yc+fc9xnfc+fcY6Cuuuqq63+j3PRUVB5MNF9VfHkw0ZybnooGuUeZDizMJB4qUtuFw2ub+ZlEPLg9f+VnEvHC4bVNRWq7MH1v1vQ+Mgr+2dQcBN+cfhfIKyLSjd8/eVGN2cvK3Z90CA1JQFrPjAnNv/vD468q3VsRIP/p5JycM39Or0iUbnwUDiJ3f9IBIwmg9fI1EZpvevSLL4QvwOt7E7MgfOszxFOKdOOPT5fN7F5U/pOP48yyCKCl3BgBzTb/9PS7ctfLAuSmdJTV29sAGvxtkMdS1C2PnwWC8BJjcUUNi4CUNX+iIhF3Nv38bK/UxbJJnD9657VwMSvM8P8UW0iw6CXGjBPbS4zFSbAoXGwxiJ/NI/+6XCzfJZSd0jYxJQF8YOILityWJwu+OZGdHHUIquSaryZmxSTO3tU2IMYQBHZbfv295ITZ8VEHqnTCBo11KqNtNHtX28JsDMEsbtvCxYmz46OOHD8II/OlYpSSEQAAZPWIzcp8OQnozEB2/I7DfHGfN723kowBAGBfj9gqwHKCEpeLdKjIfNlAidu28IfxuyUQAAAcjN6JQ9h3775g6FhmY0np6789D7QdBwYAgP2RYRvHT9XklzCRRyz6+vOlwC/EqgCAYwgWTlJoCPIY0O1VmAdCAADA/vCQzWSc2KXkCYtuX3pRlXkgJAAA7A4P2UqME/u8PIBCmQdqAAAAu0OOTUoFgfBIsW5f+jOUeQB4K2wAAIAIMYMAMRpOAIpFqcnDC7+E4rbDYrzPn5cHgtu5vBLqPBEKYMu2HdXASUhg86fyiJXbuVI9RNUAW/agQ0LVPPnL8hTB7VxZrQqiKoCtwUEHyrgwM5HHotzYanCIwACbH/XHScjkJAWATkoJs7FComOra1dXSmwN9jpc5gBeQh5EaRI5FBWgAGRyY+vrtS/mNnp7HUVsfhgh0bG19DIAZPq6bYbxe8IjsBtb36hdOb3R2xUkYT3FpGPp9IWlkO7rthUbF4CeUjCCqAiw0dXloAGmW6XHULrnkvlTpbu7bRCSBDE7FAm5tzb8IXwBNrq6HBHzZSMsuieT8U3CdPeHNth8OYHFvZXJBD/U/337drN6U9gE0GY0Eaii+VP9c/NmHPBvaJ1JcHDYlI8NpPZLtlbK9oW4UGgS5vcr923Yw1HR2DwA9GQyyzgqamH2KsYXbkXuvaZyscoC9G9t/Sssn1cyTyy6Z2cncFXZs7OzTCwGEPLFQCZTsisHGCTxWjQ6R1SquUseq6Ie2HkZqiRe6+iwqWyjgOb7dnerb+6eTRKNXGivA/BEoAdehjN/Fr+jwwYXL0HQl/17e1/XIv7xJJY1m7Kso5Rl7acikZr/wZGKROIpyzo4meNhreMDAP66cSOSsqyyCRVWKctqSllW+1XFr6uuuuqqvf4DtHiJ42XrW+MAAAAASUVORK5CYII=" style="width: 25px;">
                            @endif
                        </td>
                        <td class="center">
                            @if($item->etat_validation_souscripteur == 1)
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAABmJLR0QA/wD/AP+gvaeTAAADfklEQVRoge2YTWgUZxjHf+9MY5pao7bYpoeWilRRmwpC/UDxI4XGQhXjrOtuQorBIraBXnoQBHGLXoUepPXjYJvGnWS6u7IKsYqKSvw46cGTtYonDSp+BZIQd/bpIdbo7uzuu7upG2F+x3n+7/P8/7vDzPsO+Pj4+Pj4+FQOVWkDnsSic1HsRtQ1+oe20tY2lEs6/gI4znRM9zzwwbMrl5ggq1ndfN9Lbrw6Zxo4zjTeSB1j1DzAIp5yFsf5yGvJ+AnQ2VmL6f6FqFlZNVFzMN1eYtG5maXxEaCnp5oa8zAwP4/qQ5Q6ishLt33lA0QiBoOP/wAaNNQ1mRcqH6B+1h5gvYZyGIxWlJIXL1Y2QNyOAN9pKNPAN1gbTmYWKhcgYW8BduiJ5UescLdXpXAAx3mbjo6JxXgrSNwOIOzRVO/Cav45VzF/gES0AdPt462q28Sia4vxmLcndAJmQa1wACu8PZ8kdwDHmY6obmAiilqUSjy7Z0snFv0MMeJAtYb6CO/WfV9I5L2VSCYnkRq4AHzqUd3PO3XtrFyZ0jAxyuGuGaSlF6jTUJ/lydCqfHug/8j+ByIRg9RAJ97mATbzoO8oyeQkDSMjJDreIy3H0DEv6irV6SYd8+AVoH7mD8CaAutWkRo4RTL6fsEJjjMZqToBfKLh5ybqaSNftzzU0AJeAZSq11z7OSl1iUTX7JyKgwffxHSTwDyNfndxzUas1jua8wHPAOwEbmiu/xiR8/xpr8iqOI5JbY0NLC/cRvpBfUUw+I/m3OdkB2gK38I1F4Cc0+wxFYPjxO3WUT+iMNN7QXQevcOkjQBW6LLmvJfwfowGgw+omfIlyCHNPhOA34nbEUQUia5dIN9qrEsj0sr60Aldw5nkP5E9N8O2InpeBBbrSaUdq/mXInpnoXekjNsbgX2M/NJjxU9Y4fJejBRzJk5EG0beojKl3KGg9mGFtpTfp5jd6Lrm04i7ALhe1kQhiWu0l9XjBYrbTgdarqOGFwO9JU1TnKF/KEQw6Ja03rNlKfT0VDP46DdQIe01oq5iDi6jqe1RSTNzUPp3oZEn1A70DiU3cc0lBIN9Jc/LQfkftuL2JuBXoCqH4h5KLWVd6O+yZ3kwNl/mYocawXBQ1GZUHiJ8QSB8ZUzmeDA2Z+JAy3FMNR/oBu4iPAEVR9IL/0/zPj4+Pj4+rz3/AtUy/TZ0ya9hAAAAAElFTkSuQmCC" style="width: 25px;">
                            @else
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAABmJLR0QA/wD/AP+gvaeTAAAEi0lEQVRoge2ZTU8bVxSG33NpU5WCKCUTY4TUWBDCh+hiZmE2LMKCOwKFIqxIbQqb/ICA2k35B+2qVf9D1aZVUkWVgqgrpQsWYVEWVIaqRsIIRIlg4YliyxH4nC74ECB7fMdjFpX8Sl5Yc+fc9xnfc+fcY6Cuuuqq63+j3PRUVB5MNF9VfHkw0ZybnooGuUeZDizMJB4qUtuFw2ub+ZlEPLg9f+VnEvHC4bVNRWq7MH1v1vQ+Mgr+2dQcBN+cfhfIKyLSjd8/eVGN2cvK3Z90CA1JQFrPjAnNv/vD468q3VsRIP/p5JycM39Or0iUbnwUDiJ3f9IBIwmg9fI1EZpvevSLL4QvwOt7E7MgfOszxFOKdOOPT5fN7F5U/pOP48yyCKCl3BgBzTb/9PS7ctfLAuSmdJTV29sAGvxtkMdS1C2PnwWC8BJjcUUNi4CUNX+iIhF3Nv38bK/UxbJJnD9657VwMSvM8P8UW0iw6CXGjBPbS4zFSbAoXGwxiJ/NI/+6XCzfJZSd0jYxJQF8YOILityWJwu+OZGdHHUIquSaryZmxSTO3tU2IMYQBHZbfv295ITZ8VEHqnTCBo11KqNtNHtX28JsDMEsbtvCxYmz46OOHD8II/OlYpSSEQAAZPWIzcp8OQnozEB2/I7DfHGfN723kowBAGBfj9gqwHKCEpeLdKjIfNlAidu28IfxuyUQAAAcjN6JQ9h3775g6FhmY0np6789D7QdBwYAgP2RYRvHT9XklzCRRyz6+vOlwC/EqgCAYwgWTlJoCPIY0O1VmAdCAADA/vCQzWSc2KXkCYtuX3pRlXkgJAAA7A4P2UqME/u8PIBCmQdqAAAAu0OOTUoFgfBIsW5f+jOUeQB4K2wAAIAIMYMAMRpOAIpFqcnDC7+E4rbDYrzPn5cHgtu5vBLqPBEKYMu2HdXASUhg86fyiJXbuVI9RNUAW/agQ0LVPPnL8hTB7VxZrQqiKoCtwUEHyrgwM5HHotzYanCIwACbH/XHScjkJAWATkoJs7FComOra1dXSmwN9jpc5gBeQh5EaRI5FBWgAGRyY+vrtS/mNnp7HUVsfhgh0bG19DIAZPq6bYbxe8IjsBtb36hdOb3R2xUkYT3FpGPp9IWlkO7rthUbF4CeUjCCqAiw0dXloAGmW6XHULrnkvlTpbu7bRCSBDE7FAm5tzb8IXwBNrq6HBHzZSMsuieT8U3CdPeHNth8OYHFvZXJBD/U/337drN6U9gE0GY0Eaii+VP9c/NmHPBvaJ1JcHDYlI8NpPZLtlbK9oW4UGgS5vcr923Yw1HR2DwA9GQyyzgqamH2KsYXbkXuvaZyscoC9G9t/Sssn1cyTyy6Z2cncFXZs7OzTCwGEPLFQCZTsisHGCTxWjQ6R1SquUseq6Ie2HkZqiRe6+iwqWyjgOb7dnerb+6eTRKNXGivA/BEoAdehjN/Fr+jwwYXL0HQl/17e1/XIv7xJJY1m7Kso5Rl7acikZr/wZGKROIpyzo4meNhreMDAP66cSOSsqyyCRVWKctqSllW+1XFr6uuuuqqvf4DtHiJ42XrW+MAAAAASUVORK5CYII=" style="width: 25px;">
                            @endif
                        </td>
                    </tr>
                    @empty
                    @endforelse
                <tfoot>
                    <tr>
                        <td class="">Total</td>
                        <td class="center">{{ number_format($total_prescription, 0, '', ' ') }}</td>
                        <td class="center">{{ number_format($total_medecin_controle, 0, '', ' ') }}</td>
                        <td class="center">{{ number_format($total_medecin_assureur, 0, '', ' ') }}</td>
                    </tr>
                </tfoot>
                </tbody>
            </table>
            <br><br><br><br>
            {{-- <p style="text-align: right">
            @php
                Carbon\Carbon::setLocale('fr');
            @endphp
            Fait  {{ Carbon\Carbon::parse($commande_date)->translatedFormat('l jS F Y') }}
            </p> --}}
        </div>

        {{-- <div style="position:absolute;left:20px;top:815px;width: 50%; height: 170px; border:1px solid #00ada7;">
        <div style="position:relative; width: 100%" class="cls_011">&nbsp;&nbsp;<span class="cls_011">Informations de paiement</span></div>
        <div style="position: relative;left: 10px;top:17px" class="cls_004"><span class="cls_004">IBAN BE75 0689 3376 3251</span></div>
        <div style="position: relative;left: 10px;top:20px" class="cls_004"><span class="cls_004">BIC   GKCCBEBB</span></div>
        <div style="position: relative;left: 10px;top:23px" class="cls_004"><span class="cls_004">Communication</span></div>
        <div style="position: relative;left: 10px;top:26px" class="cls_014"><span class="cls_014">+++044/9999/97601+++</span></div>
    </div>  --}}

        <div style="position:absolute;left:390px;top:815px;width: 40%; height: 170px; border:1px solid #00ada7; background-color: #00ada7;">
            <div style="position:relative; width: 100%" class="cls_011"><span class="cls_011">Total valider</span></div>
            <div style="position:relative;left:10px;top:20px; width:" class="cls_012"><span class="cls_012">{{ number_format($total_medecin_assureur, 0, '', ' ') }} XAF</span></div>
        </div>

        <div style="position:absolute;left:40px;top:1000px" class="cls_015"><span class="cls_015">Medicasure SRL</span><span class="cls_003"> | </span><span class="cls_015">Rue Du Castel 18 - 7801 Irchonwelz</span><span class="cls_003"> | </span><span class="cls_015">BELGIQUE</span> | <span class="cls_015">N° d'entreprise : 0725888216</span></div>

    </div>

</body>

</html>