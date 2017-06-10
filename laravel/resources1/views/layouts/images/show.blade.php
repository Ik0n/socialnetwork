@extends('layouts.baseForImage')

@section('title', __('messages.images.show' ))

@section('main')

    <div class="row">

        @include('layouts.images.remove')

    </div>

    <div class="row">

        <img alt="" src="{{ asset('/storage/images/' . $image->filename) }}" class="img-responsive img-thumbnail ">

    </div>

@endsection