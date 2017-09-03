@extends('layouts.baseForImage')

@section('title', __('messages.images.creation' ))

@section('main')

    {{--

    Form::model () создаёт начальный тег формуляра (<form>). Опции:

    ⁃ files разрешает передачу файлов (атрибут enctype= "multipart/form-data" );

    ⁃ method — метод HTTP при подаче формуляра (атрибут method= "POST");

    ⁃ route — псевдоним URL (см. routes/web.php ) для подачи формуляра (action).

    --}}

    {{
    Form::model (
    $image, [
        'files' => true,
        'method' => 'POST',
        'route' => 'images.create' ,
        ])
     }}
    <div class="form-group">
        {{
        Form::label ('file', __ ('messages.image.file' ))
        }}
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
        {{
        Form::submit (__ ('messages.images.new' ), [
        'class' => 'btn btn-block btn-primary' , ])
        }}
    </div>
    {{
    Form::close ()
    }}
@endsection