@extends('emails.blue_template', ['title' => 'Победа в заявке', 'username' => $deal->winner->org_name])

@section('content')
    <p>Поздравляем! Вас выбрали победителем в заявке <b>{{$deal->name}}</b> #{{$deal->id}}</p>
    <p>{{$deal->description}}</p>
    <p></p>
    <p>Желаем приятной работы!</p>
@endsection