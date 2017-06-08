@extends('layouts.base')

@section('title', 'User editing')

@section('main')

    <a href="{{ route('users.index') }}">
        {{ trans('User list') }}
    </a>

    {{ Form::model($entity, [
            'method' => 'PUT',
            'route' => [
                'users.update',
                $entity->id
            ]
        ])
    }}

    {{ Form::label('login', 'Login') }}
    {{ Form::text('login') }}
    {{ Form::label('password', 'Password') }}
    {{ Form::text('password') }}
    {{ Form::label('email', 'Email') }}
    {{ Form::text('email') }}
    {{ Form::label('number', 'Number') }}
    {{ Form::text('number') }}
    {{ Form::label('first_name', 'First name') }}
    {{ Form::text('first_name') }}
    {{ Form::label('last_name', 'Last name') }}
    {{ Form::text('last_name') }}
    {{ Form::label('third_name', 'Third name') }}
    {{ Form::text('third_name') }}
    {{ Form::label('country', 'Country') }}
    {{ Form::text('country') }}
    {{ Form::label('city', 'City') }}
    {{ Form::text('city') }}

    {{ Form::submit('Save changing') }}

    {{ Form::close() }}

@endsection
