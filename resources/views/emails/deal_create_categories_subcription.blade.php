@extends('emails.blue_template', ['title' => 'Новая заявка в Вашей категории', 'username' => $user_name])

@section('content')
    <p>В вашей категории <b>{{$category_name}}</b> появилась новая заявка, </p>
    <p>Вы можете посмотреть ее прямо сейчас, перейдя по ссылке:</p>
    <p><a href="{{url('bids/' . $dealId)}}">{{url('bids/'. $dealId)}}</a></p>
    <br/>
@endsection
