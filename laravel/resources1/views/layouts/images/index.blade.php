@extends('layouts.baseForImage')

@section('title', __('messages.images.index' ))

@section('main')

    <div class="container-fluid">

        <div class="row">
            @foreach ($images as $image)
                <figure class="col-xs-12 col-sm-6 col-md-3 col-lg-1">
                    <a href="{{ route('images.show', [$image->id]) }}">
                        <img alt= "" src= "{{ asset('storage/images/' . $image->filename) }}" class="img-responsive img-thumbnail">
                    </a>
                    <figcaption class="text-center">
                        {{ $image->id }}
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </div>

@endsection