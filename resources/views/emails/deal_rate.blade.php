@extends('emails.blue_template', ['title' => 'Новый отзыв', 'username' => $deal->winner->org_name])

@section('content')
    <p>У вас появился новый отзыв о заявке <b>{{$deal->name}}</b> #{{$deal->id}}</p>
    <p>Вас оценили на {{$rate->rate}} из 5 баллов и оствили комментарий:</p>
    <p>{{$rate->comment}}</p>
@endsection