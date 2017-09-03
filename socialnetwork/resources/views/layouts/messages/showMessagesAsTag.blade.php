<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
</head>

@extends('layouts.base')

@section('title')
    <title>{{ $user->name }}</title>

@section('content')
    <div class="row">

        <div class="col-lg-8">
            @foreach($tag->messages as $m)
                @if($m->private == 0)
                <div class="panel panel-default">
                    <div>
                        <table class="message text-left">
                            @foreach($users as $u)
                                @if($m->user_id_sender == $u->id)
                            <tr class="autor-message">
                                <td rowspan="2">
                                    <a href="{{ route('users.show.user', ['user' => $u->name]) }}">
                                        @if($u->filename == "qqq")
                                            <img src="{{ asset('storage/images/' . "defavatar.png") }}" alt="" class="img-rounded img-crop-center">
                                        @endif
                                        @if($u->filename != "qqq")
                                            <img src="{{ asset('storage/images/' . $u->filename) }}" alt="" class="img-rounded img-crop-center">
                                        @endif
                                    </a>
                                </td>
                                <td class="tableuser">
                                    <a href="{{ route('users.show.user', ['user' => $u->name]) }}">
                                        {{ $u->name }}
                                    </a>
                                </td>
                                <td rowspan="2" align="right" width="70%">
                                    @if($m->user_id_sender == $authUser or $m->user_id_recipient == $authUser or $authUserName == 'Admin' or $odmen == 1 and $user->name != 'Admin' and $user->admin != 1 and $m->user_id_sender != 1 and $m->admin != 1)
                                        {{ Form::model($m , [
                                            'method' => 'DELETE',
                                            'route' => [
                                                'users.deleteMessageFromUser',
                                                   $user->name,
                                                   $m->id,
                                            ]
                                        ]) }}

                                        {{ Form::submit(trans('messages.delm'), ['class' => 'btn btn-primary']) }}
                                        {{ Form::close() }}
                                    @endif
                                </td>
                            </tr>
                            <tr class="data-message">
                                <td class="tableuser">
                                    {{ $m->created_at }}
                                </td>
                            </tr>
                                @endif
                                @endforeach
                        </table>
                    </div>
                    <div class="message-content">
                        <a href="#myModal{{ $m->id }}" class="modalWindow" data-toggle="modal" style="text-decoration: none; color: #636b6f">
                            {{ $m->content }}
                        </a>
                    </div>
                    <div class="text-center">
                        @if($m->filename != "not")
                            <a href="#myModal{{ $m->id }}" class="modalWindow" data-toggle="modal">
                                <img src="{{ asset('storage/images/' . $m->filename) }}" alt="" class="img-rounded img-crop-post">
                            </a>
                        @endif
                    </div>
                    <hr>
                    <div class="message">
                        {{ Form::model($m , [
                            'method' => 'POST',
                            'route' => [
                                'users.like.message',
                                $u->name,
                                $m
                            ],
                            'style'=>'display:inline-block'
                        ]) }}
                        @foreach($messages as $message)
                            @if($message->id == $m->id)
                                {{ Form::submit (
                                    $message->likes,
                                ['class' => 'btnmy btn-info heart']) }}
                                {{ Form::close() }}
                                @if($message->likeItAuth == $authUser)
                                    Вы поставили отметку мне нравится
                                @endif
                            @endif
                        @endforeach
                    </div>
                    <div class="tags-message text-right message">
                        {{trans('messages.tags').':'}}
                        @foreach($m->tags as $t)
                            <a href="{{ route('messages.show.asTag' , ['tag' => $t->title]) }}" class="add">{{ $t->title . ", " }}</a>
                        @endforeach
                    </div>
                    <hr>


                    @foreach($comments->where('message_id','=', $m->id)->take(50) as $c)
                        <div id="firstComments" class="col-lg-offset-2">
                            <table class="message text-left">
                                <tr class="autor-message-c">
                                    <td rowspan="2">
                                        @if($c->filenameAvatarUser == "qqq")
                                            <a href="{{ route('users.show.user', ['user' => $c->name]) }}">
                                                <img src="{{ asset('storage/images/' . 'defavatar.png') }}" alt="" class="img-rounded img-crop-center-c">
                                            </a>
                                        @endif
                                        @if($c->filenameAvatarUser != "qqq")
                                            <a href="{{ route('users.show.user', ['user' => $c->name]) }}">
                                                <img src="{{ asset('storage/images/' . $c->filenameAvatarUser) }}" alt="" class="img-rounded img-crop-center-c">
                                            </a>
                                        @endif
                                    </td>
                                    <td class="tableuser">
                                        <a href="{{ route('users.show.user', ['user' => $c->name]) }}">
                                            {{ $c->name }}
                                        </a>
                                    </td>
                                    <td rowspan="2" align="right" width="70%">
                                        @if($c->user_id == $authUser or $authUserName == 'Admin' or $authUser == 1 or $user->name != 'Admin' and $c->user_id != 1 and $user->admin != '1' and $c->admin != '1')
                                            {{ Form::model($c , [
                                                'method' => 'DELETE',
                                                'route' => [
                                                    'users.deleteCommentFromMessage',
                                                    $user->name,
                                                    $c->id,
                                                ]
                                            ]) }}
                                            {{ Form::submit(trans('messages.delc'), ['class' => 'btn btn-primary']) }}
                                            {{ Form::close() }}
                                        @endif
                                    </td>
                                </tr>
                                <tr class="data-message-c">
                                    <td class="tableuser">
                                        {{ $c->created_at }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-offset-2 message-content">
                            {{ $c->content }}
                        </div>
                        <div class="message">
                            {{ Form::model($c , [
                            'method' => 'POST',
                            'route' => [
                               'users.like.comment',
                               $user->name,
                               $c
                            ],
                            'style'=>'display:inline-block'
                       ]) }}
                            {{ Form::submit($c->likes, ['class' => 'btnmy btn-info heart']) }}
                            {{ Form::close() }}
                            @if($c->likeItAuth == $authUser)
                                Вы поставили отметку мне нравится
                            @endif
                        </div>
                    @endforeach

                    <script type="text/javascript">

                        function hideComments() {
                            $('#lastComments').hide(1000, function () {
                                $('#hide').hide();
                                $('#show').show();
                            });
                        }

                        function showComments() {
                            $('#lastComments').show(1000, function () {
                                $('#hide').show();
                                $('#show').hide();
                            });
                        }

                        $(document).ready (function () {
                            $("#lastComments").hide();
                            $("#hide").bind("click", hideComments());
                            $("#show").bind("click", showComments());
                        });

                    </script>

                    <? /*  @if($comments->where('message_id','=', $m->id)->count() > 5555)
                    <a href="#" id="hide" onclick="return false" style="display:none">Скрыть комментарии</a>
                    <a href="#" id="show" onclick="return false">Показать больше комментариев</a>
                    @endif
                     */ ?>

                    <? // $count = 0 ?>

                    <?/*<div id="lastComments123">
                   @foreach($comments->where('message_id','=', $m->id)->take(50) as $c)
                       <? $count++ ?>
                       @if($count > 3)
                       <div class="col-lg-offset-2">
                           <table class="message text-left">
                               <tr class="autor-message-c">
                                   <td rowspan="2">
                                       @if($c->filenameAvatarUser == "qqq")
                                           <a href="{{ route('users.show.user', ['user' => $c->name]) }}">
                                               <img src="{{ asset('storage/images/' . 'defavatar.png') }}" alt="" class="img-rounded img-crop-center-c">
                                           </a>
                                       @endif
                                       @if($c->filenameAvatarUser != "qqq")
                                           <a href="{{ route('users.show.user', ['user' => $c->name]) }}">
                                               <img src="{{ asset('storage/images/' . $c->filenameAvatarUser) }}" alt="" class="img-rounded img-crop-center-c">
                                           </a>
                                       @endif
                                   </td>
                                   <td class="tableuser">
                                       <a href="{{ route('users.show.user', ['user' => $c->name]) }}">
                                           {{ $c->name }}
                                       </a>
                                   </td>
                                   <td rowspan="2" align="right" width="70%">
                                       @if($c->user_id == $authUser)
                                           {{ Form::model($c , [
                                               'method' => 'DELETE',
                                               'route' => [
                                                   'users.deleteCommentFromMessage',
                                                   $user->name,
                                                   $c->id,
                                               ]
                                           ]) }}
                                           {{ Form::submit(trans('messages.delc'), ['class' => 'btn btn-primary']) }}
                                           {{ Form::close() }}
                                       @endif
                                   </td>
                               </tr>
                               <tr class="data-message-c">
                                   <td class="tableuser">
                                       {{ $c->created_at }}
                                   </td>
                               </tr>
                           </table>
                       </div>
                       <div class="col-lg-offset-2 message-content">
                           {{ $c->content }}
                       </div>
                       @endif
                   @endforeach
               </div>
            */ ?>

                    <div class="form-horizontal">
                        {{ Form::model(null, ['route' => [
                        'users.storeCommentToMessage',
                        $user->name,
                        $m->id,
                        ]
                        ]) }}
                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-2">
                                {{ Form::textarea('content',null, ['class' => 'form-control'])}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group align-right btn-cmmnt">
                        {{ Form::submit(trans('messages.sendc'), ['class' => 'btn btn-primary']) }}
                        {{ Form::close() }}
                    </div>
                    @if (count($errors))
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>


                <!-- Кнопка, вызывающее модальное окно -->
                <!-- HTML-код модального окна -->
                <div id="myModal{{ $m->id }}" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="message-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <div class="modal-title">
                                        <table class="message text-left">
                                            <tr class="autor-message">
                                                <td rowspan="2">
                                                    <a href="{{ route('users.show.user', ['user' => $m->name]) }}">
                                                        @if($m->filenameAvatarUser == "qqq")
                                                            <img src="{{ asset('storage/images/' . "defavatar.png") }}" alt="" class="img-rounded img-crop-center">
                                                        @endif
                                                        @if($m->filenameAvatarUser != "qqq")
                                                            <img src="{{ asset('storage/images/' . $m->filenameAvatarUser) }}" alt="" class="img-rounded img-crop-center">
                                                        @endif
                                                    </a>
                                                </td>
                                                <td class="tableuser">
                                                    <a href="{{ route('users.show.user', ['user' => $m->name]) }}">
                                                        {{ $m->name }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr class="data-message">
                                                <td class="tableuser">
                                                    {{ $m->created_at }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="message-content">
                                    {{ $m->content }}
                                </div>
                                <div class="text-center">
                                    @if($m->filename != "not")
                                        <img src="{{ asset('storage/images/' . $m->filename) }}" alt="" class="img-rounded">
                                    @endif
                                </div>
                                <hr>
                                <div class="message">
                                    {{ Form::model($m , [
                                        'method' => 'POST',
                                        'route' => [
                                            'users.like.message',
                                            $user->name,
                                            $m
                                        ],
                                        'style'=>'display:inline-block'
                                    ]) }}
                                    {{ Form::submit($m->likes, ['class' => 'btnmy btn-info heart']) }}
                                    {{ Form::close() }}
                                </div>
                                <div class="tags-message text-right message">
                                    {{trans('messages.tags').':'}}
                                    @foreach($m->tags as $t)
                                        {{ $t->title . ", " }}
                                    @endforeach
                                </div>
                                <hr>
                                @foreach($comments->where('message_id','=', $m->id)->take(50) as $c)
                                    <div id="firstComments" class="col-lg-offset-2">
                                        <table class="message text-left">
                                            <tr class="autor-message-c"><td rowspan="2">
                                                    @if($c->filenameAvatarUser == "qqq")
                                                        <a href="{{ route('users.show.user', ['user' => $c->name]) }}">
                                                            <img src="{{ asset('storage/images/' . 'defavatar.png') }}" alt="" class="img-rounded img-crop-center-c">
                                                        </a>
                                                    @endif
                                                    @if($c->filenameAvatarUser != "qqq")
                                                        <a href="{{ route('users.show.user', ['user' => $c->name]) }}">
                                                            <img src="{{ asset('storage/images/' . $c->filenameAvatarUser) }}" alt="" class="img-rounded img-crop-center-c">
                                                        </a>
                                                    @endif
                                                </td><td class="tableuser"><a href="{{ route('users.show.user', ['user' => $c->name]) }}">{{ $c->name }}</a></td>
                                            </tr>
                                            <tr class="data-message-c"><td class="tableuser">{{ $c->created_at }}</td></tr>
                                        </table>
                                    </div>
                                    <div class="col-lg-offset-2 message-content">
                                        {{ $c->content }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
            <div class="panel panel-default text-center">
            </div>
        </div>
    </div>
@endsection