@extends('layouts.base')

@section('title')
    <title>{{ $user->name }}</title>


@section('content')
    <div class="row">
       <div class="col-lg-4">
           <div class="panel panel-default">
               <div class="nameuser"><h2>{{ $user->name }}</h2></div>
               <div  class="thumbnailmy">
                   <div class="align-right ">
                    @if($user->filename == "qqq")
                        <img src="{{ asset('storage/images/' . 'defavatar.png') }}" alt="" class="img-responsive img-thumbnail">
                        @if($user->id == $authUser)
                               {{ Form::model($user , [
                                   'method' => 'get',
                                   'route' => [
                                       'users.addAvatarToUser',
                                       $user->name,
                                       $user->filename
                                   ]
                               ]) }}
                               {{ Form::submit("Добавить аватарку", ['class' => 'btn btn-primary']) }}
                               {{ Form::close() }}
                        @endif
                        <hr>
                    @endif
                    @if($user->filename != "qqq")
                        <img src="{{ asset('storage/images/' . $user->filename) }}" alt="" class="img-responsive img-thumbnail">
                            @if($user->id == $authUser)
                                {{ Form::model($user , [
                                    'method' => 'get',
                                    'route' => [
                                        'users.addAvatarToUser',
                                        $user->name,
                                        $user->filename
                                    ]
                                ]) }}
                                {{ Form::submit("Изменить аватарку", ['class' => 'btn btn-primary']) }}
                                {{ Form::close() }}
                                {{ Form::model($user , [
                                    'method' => 'POST',
                                    'route' => [
                                        'users.editAvatarFromUser',
                                        $user->name,
                                        $user->filename
                                    ]
                                ]) }}
                                {{ Form::submit("Удалить аватарку", ['class' => 'btn btn-primary']) }}
                                {{ Form::close() }}
                        @endif
                        <hr>
                    @endif
                    @if($user->id == $authUser)
                            <a href="{{ route('users.edit' , ['id' => $authUser]) }}" class="add">Изменить информацию о себе</a>
                    @endif
                   </div>
                </div>
                <div class="linetext">Оcновная информация</div>
                <div class="nameuser">
                <table class="infostyle">
                  <tr>
                      <td><div class="textlight">Фамилия: </div></td>
                      <td> {{ $user->last_name }}</td>
                  </tr>
                  <tr>
                      <td><div class="textlight">Имя: </div></td>
                      <td>{{ $user->first_name }}</td>
                  </tr>
                  <tr>
                        @if($user->third_name != null)
                      <td><div class="textlight">Отчество: </div></td>
                      <td>{{ $user->third_name }}</td>
                        @endif
                  </tr>
                  <tr>
                      <td><div class="textlight">Страна: </div></td>
                      <td>{{ $user->country }}</td>
                  </tr>
                  <tr>
                      <td><div class="textlight">Город: </div></td>
                      <td>{{ $user->city}}</td>
                  </tr>
                </table>
                </div>
               <div class="linetext">Контактная информация</div>
               <div class="nameuser">
                   <table class="infostyle">
                       <tr>
                           <td><div class="textlight">Почтовый адрес: </div></td>
                           <td> {{ $user->email }}</td>
                       </tr>
                       <tr>
                           <td><div class="textlight">Мобильный телефон: </div></td>
                           <td>{{ $user->number }}</td>
                       </tr>
                   </table>
               </div>
           </div>
       </div>
       <div class="col-lg-8">
           <div class="panel panel-default">
                <div class="linetext">Добавить запись</div>
                <div class="form-horizontal">
                    <div class="form-group">
                        {{ Form::model(null, ['files' => true, 'method' => 'POST', 'route' => ['users.storeMessageToUser',$user->name,] ]) }}
                        <div class="col-md-11 col-md-offset-1">
                            {{ Form::textarea('content',null, ['class' => 'form-control'])}}
                        </div>
                    </div>
                <div class="form-group">
                    <div class="col-md-1 col-md-offset-1">
                        {{ Form::label('tag_id', "Теги") }}
                    </div>
                    <div class="col-md-10">
                        {{ Form::text('tag_id',null, ['class' => 'form-control']) }}
                    </div>
                </div>
                    <div class="form-group">
                        <div>
                            {{ Form::label ('file', __ ('messages.image.file' )) }}
                        </div>
                        <div>
                            {{
                            Form::file('file', [
                            'aria-describedby' => 'file-help',
                            'class' => 'btn-block',
                            ])
                            }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-9">
                            {{ Form::submit(trans('messages.messages.send'), ['class' => 'btn btn-primary']) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            <div class="linetext">Записи пользователя</div>
            @foreach($messages as $m)
                    <div class="thumbnailm">
                        <div>
                            <table class="message text-left">
                                <tr class="autor-message"><td rowspan="2">
                                        @if($m->filenameAvatarUser == "qqq")
                                            <img src="{{ asset('storage/images/' . "defavatar.png") }}" alt="" class="img-rounded img-crop-center">
                                        @endif
                                        @if($m->filenameAvatarUser != "qqq")
                                            <img src="{{ asset('storage/images/' . $m->filenameAvatarUser) }}" alt="" class="img-rounded img-crop-center">
                                        @endif
                                 </td><td class="tableuser">
                                        <a href="{{ route('users.show.user', ['user' => $m->name]) }}">{{ $m->name }}</a>
                                    </td>
                                 <td rowspan="2" align="right" width="70%">
                                     @if($m->user_id_sender == $authUser or $m->user_id_recipient == $authUser)
                                         {{ Form::model($m , [
                                             'method' => 'DELETE',
                                             'route' => [
                                                 'users.deleteMessageFromUser',
                                                    $user->name,
                                                    $m->id,
                                             ]
                                         ]) }}

                                         {{ Form::submit("Удалить сообщение", ['class' => 'btn btn-primary']) }}
                                         {{ Form::close() }}
                                     @endif
                                 </td></tr>
                                <tr class="data-message"><td class="tableuser">{{ $m->created_at }}</td></tr>
                            </table>
                        </div>
                    <div class="message-content">
                        {{ $m->content }}
                    </div>
                        <div>
                            @if($m->filename != "not")
                                <img src="{{ asset('storage/images/' . $m->filename) }}" alt="" class="img-rounded img-crop-center">
                            @endif
                        </div>
                    <div class="tags-message text-right message-content">
                    Теги:
                        @foreach($m->tags as $t)
                            {{ $t->title . ", " }}
                        @endforeach
                    </div>
                        <div>
                            {{ $m->likes }}
                        </div>
                        <div>
                            {{ Form::model($m , [
                                'method' => 'POST',
                                'route' => [
                                    'users.like',
                                    $user->name,
                                    $m
                                ]
                            ]) }}

                            {{ Form::submit("Like", ['class' => 'btn btn-primary']) }}
                            {{ Form::close() }}
                        </div>
                        <div class="lineline"></div>
                        <hr/>

            @foreach($comments->where('message_id','=', $m->id) as $c)
                            <div class="col-lg-offset-2">
                                <table class="message text-left">
                                    <tr class="autor-message-c"><td rowspan="2">
                                            @if($c->filenameAvatarUser == "qqq")
                                                <img src="{{ asset('storage/images/' . "defavatar.png") }}" alt="" class="img-rounded img-crop-center">
                                            @endif
                                            @if($c->filenameAvatarUser != "qqq")
                                                <img src="{{ asset('storage/images/' . $c->filenameAvatarUser) }}" alt="" class="img-rounded img-crop-center">
                                            @endif
                                        </td><td class="tableuser">{{ $c->name }}</td>
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
                                                    {{ Form::submit("Удалить комментарий", ['class' => 'btn btn-primary']) }}
                                                    {{ Form::close() }}
                                                @endif
                                        </td></tr>
                                    <tr class="data-message-c"><td class="tableuser">{{ $c->created_at }}</td></tr>
                                </table>
                            </div>
                            <div class="col-lg-offset-2 message-content">
                                {{ $c->content }}
                            </div>

            @endforeach
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
                    <div class="form-group align-right btn-cmmnt">
                    {{ Form::submit("Отправить комментарий", ['class' => 'btn btn-primary']) }}
                    {{ Form::close() }}
                    </div>
                    </div>
                    </div>
            @endforeach
               {{ $messages->links() }}
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
    </div>
    <!-- <a href=" route('users.addImageToUser' , ['user' => $user->name]) " class="add"><h2>Отправить картинку</h2></a> -->
@endsection

