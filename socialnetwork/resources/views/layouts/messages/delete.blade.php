@extends('layouts.base')

@section('title', trans('messages.messages.deleting'))

@section('content')

    {{ Form::model($entity, [
        'method' => 'DELETE',
        'route' => [
            'messages.destroy',
            $entity->id
        ]
    ]) }}

    {{ Form::submit(trans('messages.delete')) }}

    {{ Form::close() }}

@endsection
