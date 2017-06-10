@extends('layouts.base')

@section('title', trans('messages.tag.editing'))

@section('content')

    <a href="{{ route('tags.index') }}">
        {{ trans('messages.tag.index') }}
    </a>

    {{ Form::model($entity, [
            'method' => 'PUT',
            'route' => [
                'tags.update',
                $entity->id
        ]
    ]) }}

    {{ Form::label('title', trans('messages.tag.title')) }}
    {{ Form::text('title') }}

    {{ Form::submit(trans('messages.save')) }}

    {{ Form::close() }}

@endsection
