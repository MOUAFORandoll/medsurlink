@extends('emails.layouts.app')
@section('title', $subject)
@section('content')
    {{-- <div class="content-title">
        <h1>
            Votre <span>santé</span> est notre priorité
        </h1>
        <div class="img">
            <img src="{{ asset('images/emails/man.png') }}" alt="">
        </div>
    </div> --}}
    <div class="content-body">
        <h2>Hello,</h2>
        <div class="content-body-text">
            <p>{{ $contenu }}</p>
           {{--  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias veniam sint debitis quo harum possimus fugiat expedita velit. Soluta magni distinctio fugiat error, maxime velit. Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus modi necessitatibus atque similique eius commodi delectus a quo, consequuntur cupiditate obcaecati vero maiores quos veniam?</p> --}}
        </div>
        <p class="gray-color">- {{ config('app.name') }}</p>
        <div class="text-center">
            <a href="{{ $route }}">Accéder au bon de prise en charge</a>
        </div>
    </div>
@endsection