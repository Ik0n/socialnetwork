@extends('layouts.base')

@section('title')
    <title>{{ "Пользователь : " . $user->name }}</title>


@section('content')
    <div class="row">
        <div class="container">
            <div>
                <h2>{{ "Пользователь : " . $user->name }}</h2>
                <hr>
                @if($user->filename == "qqq")
                    <img src="{{ asset('storage/images/' . 'defavatar.png') }}" alt="" class="img-responsive img-thumbnail">
                    @if($user->id == $authUser)
                    <a href="{{ route('users.addAvatarToUser' , ['user' => $user->name]) }}" class="add">Добавить аватарку</a>
                    @endif
                    <hr>
                @endif
                @if($user->filename != "qqq")
                    <img src="{{ asset('storage/images/' . $user->filename) }}" alt="" class="img-responsive img-thumbnail">
                    @if($user->id == $authUser)
                    <a href="{{ route('users.addAvatarToUser' , ['user' => $user->name]) }}" class="add">Изменить аватарку</a>
                    @endif
                    <hr>
                @endif
                {{ "Фамилия : " . $user->last_name }} <br>
                {{ "Имя : " . $user->first_name }} <br>
                @if($user->third_name != null)
                    {{ "Отчество : " . $user->third_name }}
                    <hr>
                @endif
            </div>
            <div>
                <h2>Откуда</h2>
                {{ "Страна : " . $user->country }} <br>
                {{ "Город : " . $user->city}}
                <hr>
            </div>
            <div>
                <h2>Контактные данные</h2>
                {{ "email : " . $user->email }} <br>
                {{ "Мобильный телефон : " . $user->number }}
                <hr>
            </div>
        </div>
        <div class="container">
    <table class="historyTable" align="center" border="1" width="100%">
            <tr class="history-tr-table">
                <td colspan="4" align="left">
                    <h2>Сообщения</h2>
                </td>
            </tr>
            <tr>
                {{ Form::model(null, ['route' => [
                'users.storeMessageToUser',
                $user->name,
                ]
                ]) }}
                {{ Form::label('content', trans('messages.messages.content')) }}
                {{ Form::text('content') }}
                {{ Form::label('tag_id', "Теги") }}
                {{ Form::text('tag_id') }}
                <!--
                    Form::select('tag_id[]', $tags , null, [
                        'multiple' => 'multiple',
                        'size' => '10'
                ])
                -->
                {{ Form::submit(trans('messages.messages.send')) }}
                {{ Form::close() }}
            </tr>
            @foreach($messages as $m)
                <tr class="history-tr-table">
                    <td colspan="4">
                        <h3>Сообщение от пользователя : {{ $m->name }}</h3>
                    </td>
                    <td>
                        @if($m->user_id_sender == $authUser)
                            {{ Form::model($m , [
                                'method' => 'DELETE',
                                'route' => [
                                    'users.deleteMessageFromUser',
                                    $user->name,
                                    $m->id,
                                ]
                            ]) }}

                            {{ Form::submit("Удалить сообщение") }}

                            {{ Form::close() }}
                        @endif
                    </td>
                </tr>
            <tr class="history-tr-table">
                <td>
                    {{ $m->content }}
                </td>
                <td>
                    Теги :
            @foreach($m->tags as $t)
                    {{ $t->title . ", " }}
            @endforeach
                </td>
                <td>
                    Запись оставлена :
                    {{ $m->created_at }}
                </td>
            </tr>
            <tr>
                <td colspan="4" align="left">
                    <h4>Комментарии</h4>
                </td>
            </tr>
            @foreach($comments->where('message_id','=', $m->id) as $c)
                <tr class="history-tr-table">
                    <td colspan="3">
                        <h5>Комментарий от пользователя : {{ $c->name }}</h5>
                    </td>
                    <td>
                        @if($c->user_id == $authUser)
                            {{ Form::model($c , [
                                'method' => 'DELETE',
                                'route' => [
                                    'users.deleteCommentFromMessage',
                                    $user->name,
                                    $c->id,
                                ]
                            ]) }}
                            {{ Form::submit("Удалить комментарий") }}
                            {{ Form::close() }}
                        @endif
                    </td>
                </tr>
                <tr class="history-tr-table">
                    <td colspan="3">
                        {{ $c->content }}
                    </td>
                    <td>

                    </td>
                </tr>
            @endforeach
            <tr class="history-tr-table">
                <td colspan="4">
                    {{ Form::model(null, ['route' => [
                    'users.storeCommentToMessage',
                    $user->name,
                    $m->id,
                    ]
                    ]) }}
                    {{ Form::label('content', "Комментарий") }}
                    {{ Form::text('content') }}
                    {{ Form::submit("Отправить комментарий") }}
                    {{ Form::close() }}
                </td>
            </tr>
            @endforeach
    </table>
        </div>
    </div>
    <!-- $messages->links() -->
    <div class="row">
        <div class="container">
        @foreach($images as $image)
            <table class="historyTable" align="center" border="1" width="100%">
                <tr>
                    <td>
                        <figure class="sender-image">
                            <img src="{{ asset('storage/images/' . $image->filename) }}" alt="" class="img-responsive img-thumbnail">
                            <figcaption class="sender-image">
                                {{ $image->name }}
                            </figcaption>
                        </figure>
                    </td>
                </tr>
            </table>
        @endforeach
        </div>
    </div>
    <a href="{{ route('users.addImageToUser' , ['user' => $user->name]) }}" class="add"><h2>Отправить картинку</h2></a>
@endsection

