<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
</head>

@extends('layouts.base')

@section('title')
    <title>{{ $user->name }}</title>

@section('content')
    <table class="table">
        <tr>
            <td>Отправитель</td>
            <td>Содержимое</td>
            <td class="align-right">Дата и время отправления</td>
        </tr>
@foreach($messages as $message)
    <tr>
    @if($message->user_id_sender == $user2->id and $message->user_id_recipient == $user->id or $message->user_id_sender == $user->id and $message->user_id_recipient == $user2->id)
        <td>{{ $message->user_name_sender }} :</td>
        <td>{{ $message->content }}</td>
        <td class="align-right">{{ $message->created_at }}</td>
    @endif
    </tr>
@endforeach
    </table>
<table class="table">
    <tr>
    {{ Form::model($user, [
        'method' => 'POST',
        'route' => [
            'users.myMessage.dialog.store',
            $user,
            $user2,
        ]]) }}
    <td>{{ Form::textarea('content') }}</td>
    <td>{{ Form::submit('Отправить') }}</td>
    {{ Form::close() }}
    </tr>
</table>
@endsection