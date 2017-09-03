@extends('layouts.base')

@section('title', 'Редактирование продукта')

@section('main')

    <a href="{{ route('products.index') }}">
        Вернуться к списку продуктов
    </a>

    {{ Form::model($entity, [
            'method' => 'PUT',
            'route' => [
                'products.update',
                $entity->id
        ]
    ]) }}

    {{ Form::label('Title') }}
    {{ Form::text('title') }}

    {{ Form::label('about') }}
    {{ Form::text('about') }}

    {{ Form::label('amount') }}
    {{ Form::text('amount') }}

    {{ Form::label('price') }}
    {{ Form::number('price') }}

    {{ Form::submit() }}

    {{ Form::close() }}

    @endsection
