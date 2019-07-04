@extends('emails.blue_template', ['title' => 'Обновление заявки в Вашей категории', 'username' => $user_name])

@section('content')
    <!-- <p>Уважаемый <b>{{$user_name}}</b>,</p> -->
    <p>В вашей категории <b>{{$category_name}}</b> обновилась заявка, </p>
    <p>Вы можете посмотреть ее прямо сейчас, перейдя по ссылке:</p>
    <p><a href="{{url('bids/' . $dealId)}}">{{url('bids/'. $dealId)}}</a></p>
    <br/>
@endsection
