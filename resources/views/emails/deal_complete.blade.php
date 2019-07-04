@extends('emails.blue_template', ['title' => 'Message title', 'username' => $deal->user->name])

@section('content')
    <p>Вы закрыли заявку <b>{{$deal->name}}</b> #{{$deal->id}}</p>
@endsection