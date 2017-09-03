@extends('layouts.base')

@section('title', trans('messages.userediting'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{trans('messages.userediting')}}</div>
                    <div class="panel-body">
                        <div class="col-md-6">
                            <div class="thumbnailmy">
                                @if($user->filename == "qqq")
                                    <img src="{{ asset('storage/images/' . 'defavatar.png') }}" alt="" class="img-responsive img-rounded img-thumbnail">
                                @endif
                                @if($user->filename != "qqq")
                                    <img src="{{ asset('storage/images/' . $user->filename) }}" alt="" class="img-responsive img-rounded img-thumbnail">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{
                                Form::model (null , [
                                    'files' => true,
                                    'method' => 'POST',
                                    'route' => [
                                    'users.storeAvatarToUser',
                                    $user->name,],
                                    'style'=>'display:inline-block'
                                    ])

                                 }}
                            <div class="form-group">
                                {{
                                Form:: file('file', [
                                    'aria-describedby' => 'file-help',
                                    'class' => 'btn-block',
                                    ])
                                }}
                                <small id= "file-help" class="form-text text-muted">
                                    {{ __('messages.image.file.mimes' ) }}
                                </small>
                                <div>
                                <small id= "file-help" class="form-text text-muted">
                                    {{ __('messages.image.file.max' ) }}
                                </small>
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::submit (__ ('messages.savechng' ), ['class' => 'btn btn-block btn-primary' , ])}}
                            </div>
                            {{ Form::close ()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection