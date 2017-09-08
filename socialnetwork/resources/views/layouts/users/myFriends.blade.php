<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
</head>

@extends('layouts.base')

@section('title')
    <title>{{ $user->name }}</title>

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{trans('Друзья')}}</div>
                    <div class="panel-body">
                        @if($authUser->friends->count() == 1)
                            @foreach($authUser->friends as $friend)
                            <div class="text-center">
                                <hr>
                                <table class="message text-left">
                                    <tr class="autor-message"><td rowspan="6">
                                            <a href="{{ route('users.show.user', ['user' => $friend->name]) }}">
                                                @if($friend->filename == "qqq")
                                                    <img src="{{ asset('storage/images/' . "defavatar.png") }}" alt="" class="img-rounded img-crop-center-list img-thumbnail">
                                                @endif
                                                @if($friend->filename != "qqq")
                                                    <img src="{{ asset('storage/images/' . $friend->filename) }}" alt="" class="img-rounded img-crop-center-list img-thumbnail">
                                                @endif
                                            </a>
                                        </td>
                                        <td class="tableuser">
                                            <a href="{{ route('users.show.user', ['user' => $friend->name]) }}">{{ $friend->name }}</a>
                                        </td>
                                        <td>
                                            {{ Form::model($user , [
                                            'method' => 'GET',
                                            'route' => [
                                                'users.myMessages.dialog',
                                                $user->name,
                                                $friend->name
                                            ]]) }}
                                        <td>
                                            {{ Form::submit('Перейти к диалогу', ['class' => 'btn btn-primary']) }}
                                        </td>
                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                                    <tr class="data-message">
                                        <td class="tableuser">
                                            {{ $friend->first_name.' '.$friend->last_name.' '.$friend->third_name }}
                                        </td>
                                        <td>
                                            {{ Form::model($user , [
                                            'method' => 'DELETE',
                                            'route' => [
                                                'users.deleteFromFriends',
                                                $friend->name,
                                            ]]) }}
                                        <td>
                                            {{ Form::submit('Удалить из друзей', ['class' => 'btn btn-primary']) }}
                                        </td>
                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                                    <tr class="data-message"><td class="tableuser">{{ $friend->city.', '.$friend->country }}</td></tr>
                                    <tr class="data-message"><td class="tableuser">{{ trans('messages.num').': '.$friend->number }}</td></tr>
                                    <tr class="data-message"><td class="tableuser">{{ trans('messages.email').': '.$friend->email }}</td></tr>
                                    <tr class="data-message"><td class="tableuser">{{ trans('messages.regdate').': '.$friend->created_at }}</td></tr>
                                    <? // @if($authUserName == "admin" and $u->name != "admin" or $authUser->admin == '1' and $u->admin == '0' and $u->name != 'admin' or $odmen == 1 and $u->name != 'admin' and $u->admin != '1')
                                    ?>
                                </table>
                            </div>
                        @endforeach
                        @else
                            <div class="row panel panel-default">
                                <div class="col-md-12 text-center">
                                    <h2 class="">В данный момент у вас нет друзей</h2>
                                    <a href="{{ route('users.index') }}">
                                        <h2>Вы можете воспользоваться поиском и найти себе друзей</h2>
                                    </a>
                                </div>
                            </div>
                        @endif
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@endsection