@extends('layouts.base')

@section('title', trans('User addition'))

@section('main')

    <div class="row">
        <div class="container">
            {{ Form::model($entity, ['route' => 'users.store']) }}
                <div class="col-md-12">
                    {{ Form::label('name' ,trans('Name')) }}
                    {{ Form::text('name') }}
                </div>

                <div class="col-md-12">
                    {{ Form::label('password', 'Password') }}
                    {{ Form::text('password') }}
                </div>

                <div class="col-md-12">
                    {{ Form::label('email', 'Email') }}
                    {{ Form::text('email') }}
                </div>

                <div class="col-md-12">
                    {{ Form::label('number','Number') }}
                    {{ Form::text('number') }}
                </div>

                <div class="col-md-12">
                    {{ Form::label('first_name','First name') }}
                    {{ Form::text('first_name') }}

                <div class="col-md-12">
                    {{ Form::label('last_name','Last name') }}
                    {{ Form::text('last_name') }}
                </div>

                <div class="col-md-12">
                    {{ Form::label('third_name','Third name') }}
                    {{ Form::text('third_name') }}
                </div>

                <div class="col-md-12">
                    {{ Form::label('country','Country') }}
                    {{ Form::text('country') }}
                </div>

                <div class="col-md-12">
                    {{ Form::label('city','City') }}
                    {{ Form::text('city') }}
                </div>

                <div class="col-md-12">
                    {{ Form::submit('Add user') }}
                </div>

            {{ Form::close() }}
                </div>
        </div>

    @endsection