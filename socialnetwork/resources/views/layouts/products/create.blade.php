

@section('title', trans('messages.product.creation'))

@section('main')


    {{ Form::model($entity, ['route' => 'products.store']) }}

        {{ Form::label(trans('messages.product.title')) }}
        {{ Form::text('title') }}

        {{ Form::label('about') }}
        {{ Form::text('about') }}

        {{ Form::label('amount') }}
        {{ Form::text('amount') }}

        {{ Form::label('price') }}
        {{ Form::number('price') }}

        {{ Form::submit(trans('messages.product.create')) }}

    {{ Form::close() }}

    @endsection