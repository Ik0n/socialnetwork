@extends('layouts.base')

@section('title', trans('messages.tag.creation'))

@section('content')


    {{ Form::model($entity, ['route' => 'tags.store']) }}

        {{ Form::label('title' ,trans('messages.tag.title')) }}
        {{ Form::text('title') }}

        {{ Form::submit(trans('messages.tag.create')) }}

    {{ Form::close() }}

    @endsection