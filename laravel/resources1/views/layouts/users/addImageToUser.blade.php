@extends('layouts.base')

@section('title', trans('messages.messages.creation'))

@section('content')

    {{

        Form::model ($image, [
            'files' => true,
            'method' => 'POST',
            'route' => [
            'users.storeImageToUser',
            $user->name,],
            ])

         }}

    <div class="form-group">

        {{-- Подпись к виджету. --}}

        {{

        Form::label ('file', __ ('messages.image.file' ))

        }}

        {{-- Виджет для выбора локального файла. --}}

        {{

        Form:: file('file', [
            'aria-describedby' => 'file-help',
            'class' => 'btn-block',
            ])

        }}

        <small id= "file-help" class="form-text text-muted">

            {{ __('messages.image.file.mimes' ) }}

        </small>

    </div>

    <div class="form-group">

        {{-- Кнопка подачи формуляра. --}}

        {{

        Form::submit (__ ('messages.images.new' ), [

        'class' => 'btn btn-block btn-primary' ,

        ]

        )

        }}

    </div>

    {{-- Конечный тег формуляра (</form>) --}}

    {{

    Form::close ()

    }}

@endsection