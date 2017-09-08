@extends('layouts.base')

@section('title', trans('messages.users'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{trans('messages.users')}}</div>
                    <div class="panel-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                {{ Form::model(null , [
                                    'method' => 'GET',
                                    'route' => [
                                    'users.index',
                                    ]])
                                }}
                                <div class="col-md-10">
                                    {{ Form::text('search', null, ['class' => 'form-control']) }}
                                </div>
                                <div class="col-md-2">
                                    {{ Form::submit('Поиск', ['class' => 'btn btn-primary'])}}
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>

                    @foreach($searchUsers as $user)
                        <div class="text-center">
                            <hr>
                            <table class="message text-left">
                                <tr class="autor-message"><td rowspan="6">
                                        <a href="{{ route('users.show.user', ['user' => $user->name]) }}">
                                            @if($user->filename == "qqq")
                                                <img src="{{ asset('storage/images/' . "defavatar.png") }}" alt="" class="img-rounded img-crop-center-list img-thumbnail">
                                            @endif
                                            @if($user->filename != "qqq")
                                                <img src="{{ asset('storage/images/' . $user->filename) }}" alt="" class="img-rounded img-crop-center-list img-thumbnail">
                                            @endif
                                        </a>
                                    </td>
                                    <td class="tableuser">
                                        <a href="{{ route('users.show.user', ['user' => $user->name]) }}">{{ $user->name }}</a>
                                    </td>
                                        @if($userAuth->name != $user->name)
                                            @if($userAuth->friends->contains($user))
                                                <td>
                                                    Уже в друзьях
                                                </td>
                                            @else
                                            <td>
                                                {{ Form::model($user , [
                                                    'method' => 'POST',
                                                    'route' => [
                                                        'users.addToFriends',
                                                        $user->name
                                                    ]
                                                    ]) }}
                                                {{ Form::submit(trans('Добавить в друзья'), ['class' => 'btn btn-primary']) }}
                                                {{ Form::close() }}
                                            </td>
                                            @endif
                                        @endif
                                </tr>
                                <tr class="data-message"><td class="tableuser">{{ $user->first_name.' '.$user->last_name.' '.$user->third_name }}</td></tr>
                                <tr class="data-message"><td class="tableuser">{{ $user->city.', '.$user->country }}</td></tr>
                                <tr class="data-message"><td class="tableuser">{{ trans('messages.num').': '.$user->number }}</td></tr>
                                <tr class="data-message"><td class="tableuser">{{ trans('messages.email').': '.$user->email }}</td></tr>
                                <tr class="data-message"><td class="tableuser">{{ trans('messages.regdate').': '.$user->created_at }}</td></tr>
                                <? // @if($authUserName == "admin" and $u->name != "admin" or $authUser->admin == '1' and $u->admin == '0' and $u->name != 'admin' or $odmen == 1 and $u->name != 'admin' and $u->admin != '1')
                                ?>
                                @if($authUserName == "Admin" and $user->name != "Admin" or $authUser->admin == '1' and $user->admin == '0' and $user->name != 'Admin')
                                <tr><td>     {{ Form::model($user , [
                                             'method' => 'DELETE',
                                             'route' => [
                                                 'users.destroy',
                                                  $user->id
                                             ]
                                         ]) }}
                                        {{ Form::submit("Удалить"), ['class' => 'btn btn-primary'] }}
                                        {{ Form::close() }}
                                </td></tr>
                                @endif
                            </table>
                        </div>
                        @endforeach
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
