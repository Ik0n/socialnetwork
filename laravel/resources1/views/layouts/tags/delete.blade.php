@extends('layouts.base')

@section('title', trans('messages.tag.deleting'))

@section('content')

    {{ Form::model($entity, [
        'method' => 'DELETE',
        'route' => [
            'tags.destroy',
            $entity->id
        ]
    ]) }}

    {{ Form::submit(trans('messages.delete')) }}

    {{ Form::close() }}

@endsection
