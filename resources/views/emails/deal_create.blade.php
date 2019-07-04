@extends('emails.blue_template', ['title' => 'Создание заявки', 'username' => $deal->user->name])

@section('content')
    <p>Вы создали новую заявку <b>{{$deal->name}}</b>, с номером {{$deal->id}}, в данный момент она проходит модерацию.</p>
@endsection