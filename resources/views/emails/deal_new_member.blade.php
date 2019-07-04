@extends('emails.blue_template', ['title' => 'Новый участник', 'username' => $deal->user->name])

@section('content')
    <p>На заявку <b>{{$deal->name}}</b> #{{$deal->id}} отреагировал новый участник <b>{{$member->org_name}}</b></p>
@endsection