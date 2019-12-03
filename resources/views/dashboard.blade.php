<!DOCTYPE html>
<html lang="fr" xmlns:og="http://ogp.me/ns#">
<head>
    <title>Dashboard | Medicalink </title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="la solution d'intermédiation médicale personnalisée et participative">
    <meta name="keywords" content="Assurance, Afrique, Professionnel, rapport médical informatisé, réseaux partenaires, facturation controlée">

    <!--Favicon-->
    <meta property="og:title" content="Medicasure" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="https://www.medicasure.com" />
    <meta property="og:image" content="https://www.medicasure.com/images/meta.jpg"/>

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@Medicasure" />
    <meta name="twitter:title" content="Medicasure" />
    <meta name="twitter:description" content="la solution d'intermédiation médicale personnalisée et participative" />
    <meta name="twitter:image" content="{{ asset('images/meta.jpg')}}" />

    <!-- Vuetify CSS -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet">
    <link href="{{ config('app.url') . '/node_modules/vuetify/dist/vuetify.min.css' }}" rel="stylesheet">

    <!-- FontAwesome CSS -->
    <link href="{{ config('app.url') . '/node_modules/@fortawesome/fontawesome-free/css/all.css' }}" rel="stylesheet">

    <!-- NProgress CSS -->
    <link href="{{ config('app.url') . '/node_modules/nprogress/nprogress.css' }}" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('images/favicon/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{asset('images/favicon/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('images/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('images/favicon/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('images/favicon/manifest.json')}}">
    <!-- Bootstrap CSS -->

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!--Dropdown-->
        <!-- Global site tag (gtag.js) - Google Analytics -->
          <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-133825330-1"></script>
          <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-133825330-1');
          </script> -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Swiper CSS -->

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/2fa373d2641667e7886cc3e20/4edfddddaaad9ad6c76b6200f.js");</script>

    <!-- Scripts -->
    <script>
        window.Medicalink = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <script src="https://use.fontawesome.com/9712be8772.js"></script>
</head>
<body>
    <div id="app">
        <router-view></router-view>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
