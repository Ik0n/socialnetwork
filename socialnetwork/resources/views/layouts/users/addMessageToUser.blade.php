@extends('layouts.base')

@section('title', trans('messages.messages.creation'))

@section('content')

    {{ Form::model($entity, ['route' => [
        'users.storeMessageToUser',
        $user->name,
        ]
        ]) }}

    {{ Form::label('content', trans('messages.messages.content')) }}
    {{ Form::text('content') }}

    {{
        Form::select('tag_id[]', $tags , null, [
            'multiple' => 'multiple',
            'size' => '10'
    ])

    }}

    {{ Form::submit(trans('messages.messages.send')) }}

    {{ Form::close() }}
@endsection