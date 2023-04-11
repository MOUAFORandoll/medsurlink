<html>
    <head>
        <title>
            {{ $subject }}
        </title>
    </head>
    <body>
        <div> {{ $contenu }} </div>
        <div>
            {{ $route }}
        </div>

        Cliquez sur le lien ci-dessous
        <div>
             <a href="{{ $route }}">{{ $route }}</a>
         </div>
    </body>
</html>