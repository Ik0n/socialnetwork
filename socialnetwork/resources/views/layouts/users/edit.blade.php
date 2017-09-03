@extends('layouts.base')

@section('title', trans('messages.userediting'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{trans('messages.userediting')}}</div>
                    <div class="panel-body">
                    <div class="form-horizontal">
                            {{ Form::model($user, [
                                    'method' => 'PUT',
                                    'route' => [
                                        'users.update',
                                        $user->id
                                    ]
                                ])
                            }}
                        <div class="form-group">
                            <div class="col-md-4 control-label">
                                {{ Form::label('email', trans('messages.email')) }}
                            </div>
                            <div class="col-md-6">
                                {{ Form::text('email',$user->email, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 control-label">
                                {{ Form::label('number', trans('messages.num')) }}
                            </div>
                            <div class="col-md-6">
                                {{ Form::text('number',$user->number, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 control-label">
                                {{ Form::label('first_name', trans('messages.fn')) }}
                            </div>
                            <div class="col-md-6">
                                {{ Form::text('first_name',$user->first_name, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 control-label">
                                {{ Form::label('last_name', trans('messages.sn')) }}
                            </div>
                            <div class="col-md-6">
                                {{ Form::text('last_name',$user->last_name, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 control-label">
                                {{ Form::label('third_name', trans('messages.tn')) }}
                            </div>
                            <div class="col-md-6">
                                {{ Form::text('third_name',$user->third_name, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 control-label">
                                {{ Form::label('country', trans('messages.country')) }}
                            </div>
                            <div class="col-md-6">
                                {{ Form::text('country',$user->country, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 control-label">
                                {{ Form::label('city', trans('messages.city')) }}
                            </div>
                            <div class="col-md-6">
                                {{ Form::text('city',$user->city, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {{ Form::submit( trans('messages.savechng'), ['class' => 'btn btn-primary']) }}
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
                </div>
                </div>
        </div>
    </div>
@endsection
