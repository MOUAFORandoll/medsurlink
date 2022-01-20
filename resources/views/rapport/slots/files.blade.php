@if(count($files)>0)
    <p>Consulter les pièces jointes</p>
    @foreach($files as $file)
        <a href="{{config('app.url')}}/public/storage/{{$file->chemin}}">{{$file->nom}}</a><br>
    @endforeach
@endif
