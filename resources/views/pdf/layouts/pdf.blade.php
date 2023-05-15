<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,400i,500,500i,600,700,800,900&display=swap" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900&display=swap' rel='stylesheet'>


    <title>@yield('title')</title>
    <style>

        @page { 
            margin: 65px 0px; 
            font-family: 'Montserrat', sans-serif;
        }
        #header { 
            position: fixed; 
            left: 0px; 
            top: -65px; 
            right: 1px; 
            height: 65px; 
            background-image: url("{{ public_path('images/pdf/header.png') }}");
            background-position: center;
            background-size: cover; 
            text-align: center;
            padding-top: 1rem;
            padding-left: 2rem; 
        }

        #footer { 
            position: fixed; 
            left: 0px; 
            bottom: -70px; 
            right: 0px; 
            height: 70px;
            background-image: url("{{ public_path('images/pdf/footer.png') }}");
            background-position: center;
            background-size: cover;
            padding-top: .25rem;
        }

        #footer .page:after { 
            content: counter(page, upper-roman); 
        }

        #footer li, td, p{
            font-size: 12px;
        }

        ol li{
            font-size: 12px;
            color: #32325d;
        }

        #footer ul .info{
            color: #f2f2f2;
        }

        #footer ul .title{
            color: #2dcecc;
        }
        .img{
            max-width: 30%;
        }
        .img img{
            max-width: 70%;
        }

        .info-user{
            background-color: #f2f2f2;
            padding: 1rem 1rem;
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
            padding-top: .3rem;
        }

        .info-user .li-top{
            margin-bottom: .3rem;
        }

        .info-user ul .title{
            color: #2dcecc;
            font-size: 12px;
        }

        .info-user ul .info{
            color: #32325d;
            font-weight: 600;
            font-size: 12px;
            /*text-transform: uppercase;*/
        }

        /* li.li-top span:nth-child(2){
            margin-right: 2rem;
        } */

        li.li-bottom .span{
            margin-left: 13rem;
        }

        .content h1{
            text-align: center;
            color: #2dcecc;
            text-transform: uppercase;
            font-weight: 700;
            font-size: 16px;
            margin-bottom: .3rem;
        }
        .legend-list {
            color: #32325d;
            margin-bottom: 15px;
        }

        .content p{
            font-weight: normal;
            color: #32325d;
            margin: 1 1 1 1;
            padding: 1 1 1 1;
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
            font-size: 12px;
        }
        .content-field ul{
            padding: 0rem;
            font-size: 1.2rem;
            font-weight: normal;
            line-height: 1.5;
            color: #32325d;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            color: #32325d;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 5px;
            color: #32325d;
            font-size: 12px;
        }
        h2{
            font-size: 14px;
        }

        /* tr:nth-child(even) {
            background-color: #dddddd;
        } */

        ul, li{
            margin: 0;
            padding: 0;
        }

        ol, li{
            margin-top: 0px;
            margin-bottom: 0px;
            padding-bottom: 0px;
            padding-top: 0px;
        }

        .list-none{
            list-style: none;
        }

        .default-margin{
            padding: 0 2.5rem;
        }
        .mt-2{
            margin-top: 1.4rem;
        }
        .mb-2{
            margin-bottom: 1.4rem;
        }

        .w-content{
            width: fit-content;
        }

        .text-center{
            text-align: center;
        }

        .p-0{
            padding: 0;
        }

        .m-0{
            margin: 0;
        }

        .white{
            color: #fff;
        }

        #pageCounter {
            counter-reset: pageTotal;
        }
        #pageCounter span {
        counter-increment: pageTotal;
        }
        #pageNumbers {
        counter-reset: currentPage;
        }
        #pageNumbers div:before {
        counter-increment: currentPage;
        content: counter(currentPage) " / ";
        }
        #pageNumbers div:after {
        content: counter(pageTotal);
        }

    </style>
</head>
<body>
    @include('pdf.includes.header')
    @include('pdf.includes.footer')
    @yield('content')
</body>
</html>