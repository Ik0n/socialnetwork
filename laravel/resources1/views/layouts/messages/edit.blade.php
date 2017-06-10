@extends('layouts.base')

@section('title', trans('messages.messages.editing'))

@section('content')

    <a href="{{ route('messages.index') }}">
        {{ trans('messages.messages.list') }}
    </a>

    {{ Form::model($entity, [
            'method' => 'PUT',
            'route' => [
                'messages.update',
                $entity->id
            ]
    ])
    }}

    {{ Form::label('content', trans('messages.messages.content')) }}
    {{ Form::text('content') }}

    {{
        Form::select('tag_id[]', $tags, null, [
            'multiple' => 'multiple',
            'size' => '10',
        ])
    }}

    {{ Form::submit(trans('messages.save')) }}
    {{ Form::close() }}

@endsection
