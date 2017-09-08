<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
</head>

@extends('layouts.base')

@section('title')
    <title>{{ $user->name }}</title>

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <table class="table">
                    <tr>
                        <td colspan="2">Отправитель</td>
                        <td>Содержимое</td>
                        <td class="align-right">Дата и время отправления</td>
                    </tr>
                    @foreach($messages as $message)
                        <tr>
                            @if($message->user_id_sender == $user2->id and $message->user_id_recipient == $user->id or $message->user_id_sender == $user->id and $message->user_id_recipient == $user2->id)
                                <td>
                                    @if($message->user_avatar_sender == "qqq")
                                            <img src="{{ asset('storage/images/' . 'defavatar.png') }}" alt="" class="img-rounded img-crop-center-c">
                                    @endif
                                    @if($message->user_avatar_sender != "qqq")
                                            <img src="{{ asset('storage/images/' . $message->user_avatar_sender) }}" alt="" class="img-rounded img-crop-center-c">
                                    @endif
                                </td>
                                <td>{{ $message->user_name_sender }} :</td>
                                <td>{{ $message->content }}</td>
                                <td class="align-right">{{ $message->created_at }}</td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-lg-12 text-center">
            {{ Form::model(null, [
                'method' => 'POST',
                'route' => [
                    'users.myMessage.dialog.store',
                    $user,
                    $user2,
                ]]) }}
            {{ Form::textarea('content', null, ['class' => 'form-control']) }}
            <hr>
            {{ Form::submit('Отправить', ['class' => 'btn btn-primary']) }}
            {{ Form::close() }}
        </div>
    </div>
@endsection