@extends('layouts.base')

@section('title', 'User deleting')

@section('main')

    {{ Form::model($entity, [
        'method' => 'DELETE',
        'route' => [
                'users.destroy',
                $entity->id
            ]
        ])
    }}

    {{ Form::submit('Delete user') }}

    {{ Form::close() }}

@endsection
