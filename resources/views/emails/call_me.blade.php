@extends('emails.blue_template', ['title' => 'Заказ звонка клиентом', 'username' => 'клиент'])

@section('content')
    <p>Номер телефона, для связи с клиентом:  <b>{{$phone}}</b></p>
    <br/>
@endsection