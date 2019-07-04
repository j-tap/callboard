@extends('emails.blue_template', ['title' => 'Редактирование заявки', 'username' => $deal->user->name])

@section('content')
    <p>Вы отредактировали заявку <b>{{$deal->name}}</b>, с номером {{$deal->id}}, в данный момент она проходит модерацию.</p>
@endsection