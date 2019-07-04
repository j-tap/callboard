@extends('emails.blue_template', ['title' => 'Сброс пароля', 'username' => $user->name])

@section('content')
    <p>Вы от вас поступила заявка на сброс пароля в TamTem.</p>
    <p>Ваш новый пароль для входа в систему <b>{{ $new_password }}</b></p>
    <p>Чтобы подтвердить сброс текущего пароля и замену, на присланный новый пароль, пройдите по ссылке:</p>
    <p><a href="{{route('password.reset.confirm', ['token' => $password_reset_token])}}">{{route('password.reset.confirm', ['token' => $password_reset_token])}}</a></p>
    <br/>
@endsection