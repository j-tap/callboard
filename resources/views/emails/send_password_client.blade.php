@extends('emails.blue_template', ['title' => 'Данные для доступа к сервису', 'username' => $user->name])

@section('content')
    <p>Вы успешно зарегистрированны в TamTem.</p>
    <p>Ваш  логин для входа в систему <b>{{ $email }}</b></p>
    <p>Ваш  пароль для входа в систему <b>{{ $password }}</b></p>
    <br/>
@endsection