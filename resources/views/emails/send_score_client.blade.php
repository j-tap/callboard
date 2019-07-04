@extends('emails.blue_template', ['title' => 'Данные для доступа к сервису', 'username' => $user->name])

@section('content')
    <p>{{$msg}}</p>
    <br/>
@endsection