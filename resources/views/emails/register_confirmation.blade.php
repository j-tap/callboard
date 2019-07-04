@extends('emails.blue_template', ['title' => 'Подтверждение регистрации', 'username' => $user->name])

@section('content')
    <p>Вы зарегистрировались на портале TamTem,</p>
    <p>для подтверждения регистрации пройдите по ссылке:</p>
    <p><a href="{{route('register.confirm', ['token' => $user->register_confirm_token])}}">{{route('register.confirm', ['token' => $user->register_confirm_token])}}</a></p>
    <br/>
@endsection