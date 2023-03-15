<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <style>

        html, body{
            margin: 0;
            padding: 0;
        }
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            height: 100px;
            background-image: url("{{ public_path('images/pdf/header.png') }}");
            background-position: center;
            background-size: cover;
            padding-top: 2rem;
            padding-left: 2rem;
        }

        footer{
            position: fixed ;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            height: 60px;
            background-image: url("{{ public_path('images/pdf/footer.png') }}");
            background-position: center;
            background-size: cover;
            padding: 1rem;
        }
        .container{
            /* margin-top: 8rem;
            margin-bottom: 8rem; */
        }
        /* footer:before{
            content: "Page " counter(page)
        } */

        footer li{
            font-size: 14px;
        }

        footer ul .info{
            color: #f2f2f2;
        }

        footer ul .title{
            color: #2dcecc;
        }
        .img{
            max-width: 30%;
        }
        .img img{
            max-width: 100%;
        }

        .info-user{
            background-color: #f2f2f2;
            padding: 1rem 2rem;
            margin-top: 1rem;
        }

        .info-user h2{
            margin: 0;
            padding: 0;
            text-align: center;
            color: #2dcecc;
            text-transform: uppercase;
        }

        .info-user ul{
            padding-top: 1.5rem;
        }

        .info-user ul .title{
            color: #2dcecc;
        }

        .info-user ul .info{
            color: #32325d;
            font-weight: 600;
            text-transform: uppercase;
        }

        .li-top{
            margin-bottom: 1rem;
        }

        li.li-top span:nth-child(2){
            margin-right: 2rem;
        }

        li.li-bottom .span{
            margin-left: 14rem;
        }

        .content{
            margin-top: 1rem;
        }

        .content h1{
            text-align: center;
            color: #2dcecc;
            text-transform: uppercase;
            font-weight: 700
        }

        .content p{
            font-size: 1.2rem;
            font-weight: normal;
            color: #32325d;
        }

        .content strong{
            color: #32325d;
        }

        .content-field{
            border: 1.5px solid #dfdfdf;
            /* border-radius: 8px; */
        }
        .content-field legend{
            color: #2dcecc;
            text-transform: uppercase;
        }
        .content-field ul{
            padding: .5rem 0rem;
            font-size: 1.2rem;
            font-weight: normal;
            line-height: 1.5;
            color: #32325d;
        }

        ul, li{
            margin: 0;
            padding: 0;
        }

        .list-none{
            list-style: none;
        }

        .default-margin{
            padding: 0 2.5rem;
        }
        .mt-2{
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    @include('pdf.includes.header')
    @yield('content')
    @include('pdf.includes.footer')
</body>
</html>