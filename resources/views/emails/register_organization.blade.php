@extends('emails.blue_template', ['title' => 'Регистрация организации', 'username' => $organization->owner->name])

@section('content')
    <p>Поздравляем Вас с регистрацией организации <b>{{$organization->org_name}}</b></p>
    <br>
    <p>Желаем Вам приятной работы с нашим сервисом!</p>
@endsection