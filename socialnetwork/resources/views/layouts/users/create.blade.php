@extends('layouts.base')

@section('title', trans('User addition'))

@section('content')

        <h1>Регистрация администратора</h1>

    <div class="row">
        <div class="container">
            {{ Form::model($entity, ['route' => 'users.store']) }}
                <div class="col-md-12">
                    {{ Form::label('name' , 'Имя') }}
                        {{ Form::text('name') }}
                </div>

                <div class="col-md-12">
                    {{ Form::label('password', 'Пароль') }}
                        {{ Form::text('password') }}
                </div>


                <div class="col-md-12">
                    {{ Form::label('email', 'Электронная почта') }}
                        {{ Form::email('email') }}
                </div>

                <div class="col-md-12">
                    {{ Form::label('number','Мобильный телефон') }}
                        {{ Form::text('number') }}
                </div>

                <div class="col-md-12">
                    {{ Form::label('first_name','Имя') }}
                        {{ Form::text('first_name') }}
                </div>


                <div class="col-md-12">
                    {{ Form::label('last_name','Фамилия') }}
                        {{ Form::text('last_name') }}
                </div>

                <div class="col-md-12">
                    {{ Form::label('third_name','Отчество') }}
                    {{ Form::text('third_name') }}
                </div>

                <div class="col-md-12">
                    {{ Form::label('country','Страна') }}
                    {{ Form::text('country') }}
                </div>

                <div class="col-md-12">
                    {{ Form::label('city','Город') }}
                    {{ Form::text('city') }}
                </div>

                <div class="col-md-12">
                    {{ Form::submit('Зарегистрировать') }}
                </div>

            {{ Form::close() }}
                @if (count($errors))
                        <ul>
                                @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                @endforeach
                        </ul>
                @endif
        </div>
    </div>

@endsection